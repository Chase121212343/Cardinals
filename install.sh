#!/usr/bin/env bash
# Cardinals Panel — one-line installer for WSL2 / Linux
# Usage: curl -fsSL https://raw.githubusercontent.com/Chase121212343/Cardinals/main/install.sh | bash
# Or locally: bash install.sh
set -euo pipefail

EAGLE_DIR="${EAGLE_INSTALL_DIR:-$HOME/cardinals}"
REPO_BASE="https://github.com/pterodactyl"
COMPOSE_VERSION="2"

RED='\033[0;31m'; GREEN='\033[0;32m'; YELLOW='\033[1;33m'; CYAN='\033[0;36m'; NC='\033[0m'
info()    { echo -e "${CYAN}[cardinals]${NC} $*"; }
success() { echo -e "${GREEN}[cardinals]${NC} $*"; }
warn()    { echo -e "${YELLOW}[cardinals]${NC} $*"; }
die()     { echo -e "${RED}[cardinals] ERROR:${NC} $*" >&2; exit 1; }

# ── Checks ──────────────────────────────────────────────────────────────────

check_wsl() {
  if grep -qi microsoft /proc/version 2>/dev/null; then
    info "WSL2 detected."
    # Warn if Docker Desktop isn't running
    if ! docker info &>/dev/null; then
      warn "Docker is not responding."
      warn "On WSL2, start Docker Desktop on Windows (with WSL2 integration enabled),"
      warn "or install Docker Engine inside WSL: https://docs.docker.com/engine/install/ubuntu/"
      die "Docker not available. Fix Docker, then re-run this script."
    fi
  fi
}

check_deps() {
  local missing=()
  for cmd in git curl docker; do
    command -v "$cmd" &>/dev/null || missing+=("$cmd")
  done
  if [[ ${#missing[@]} -gt 0 ]]; then
    warn "Missing: ${missing[*]}"
    info "Attempting auto-install (requires sudo)..."
    sudo apt-get update -qq
    sudo apt-get install -y -qq git curl
    # Docker needs special handling
    if [[ " ${missing[*]} " == *" docker "* ]]; then
      info "Installing Docker Engine..."
      curl -fsSL https://get.docker.com | sudo sh
      sudo usermod -aG docker "$USER"
      warn "Added $USER to docker group. You may need to log out/in or run: newgrp docker"
      export DOCKER_HOST=unix:///var/run/docker.sock
    fi
  fi
}

# ── Clone or update repos ────────────────────────────────────────────────────

clone_or_pull() {
  local name="$1" url="$2" dest="$3"
  if [[ -d "$dest/.git" ]]; then
    info "Updating $name..."
    git -C "$dest" pull --ff-only --quiet
  else
    info "Cloning $name (shallow)..."
    git clone --depth=1 --quiet "$url" "$dest"
  fi
}

# ── Rebrand ──────────────────────────────────────────────────────────────────

rebrand() {
  info "Applying Cardinals branding..."

  # Views
  find "$EAGLE_DIR/panel/resources/views" -type f -name "*.php" -print0 \
    | xargs -0 sed -i \
      -e 's/>Pterodactyl</>Cardinals</g' \
      -e 's/Pterodactyl Panel/Cardinals Panel/g' \
      -e 's/Pterodactyl | /Cardinals | /g' \
      -e 's/pterodactyl\.io/cardinals\.local/g'

  # Frontend scripts
  find "$EAGLE_DIR/panel/resources/scripts" -type f \( -name "*.tsx" -o -name "*.ts" -o -name "*.js" \) -print0 \
    | xargs -0 sed -i \
      -e "s/'Pterodactyl'/'Cardinals'/g" \
      -e 's/"Pterodactyl"/"Cardinals"/g' \
      -e 's/Pterodactyl Panel/Cardinals Panel/g'

  # App config default name
  sed -i "s/env('APP_NAME', 'Pterodactyl')/env('APP_NAME', 'Cardinals')/" \
    "$EAGLE_DIR/panel/config/app.php" 2>/dev/null || true

  # Lang files
  sed -i "s/Pterodactyl/Cardinals/g" \
    "$EAGLE_DIR/panel/resources/lang/en/strings.php" \
    "$EAGLE_DIR/panel/resources/lang/en/validation.php" 2>/dev/null || true

  success "Branding applied."
}

# ── Write docker-compose ─────────────────────────────────────────────────────

write_compose() {
  cat > "$EAGLE_DIR/docker-compose.yml" << 'COMPOSE'
x-common:
  database:
    &db-environment
    MYSQL_PASSWORD: &db-password "cardinals_db_pass"
    MYSQL_ROOT_PASSWORD: "cardinals_root_pass"
  panel:
    &panel-environment
    APP_NAME: "Cardinals"
    APP_URL: "http://localhost"
    APP_TIMEZONE: "UTC"
    APP_SERVICE_AUTHOR: "noreply@cardinals.local"
  mail:
    &mail-environment
    MAIL_FROM: "noreply@cardinals.local"
    MAIL_DRIVER: "log"
    MAIL_HOST: "localhost"
    MAIL_PORT: "1025"
    MAIL_USERNAME: ""
    MAIL_PASSWORD: ""
    MAIL_ENCRYPTION: "false"

services:
  database:
    image: mariadb:11
    restart: unless-stopped
    command: --default-authentication-plugin=mysql_native_password
    volumes:
      - cardinals_db:/var/lib/mysql
    environment:
      <<: *db-environment
      MYSQL_DATABASE: "panel"
      MYSQL_USER: "cardinals"
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
      interval: 10s
      timeout: 5s
      retries: 5

  cache:
    image: redis:alpine
    restart: unless-stopped

  panel:
    image: ghcr.io/pterodactyl/panel:latest
    restart: unless-stopped
    ports:
      - "80:80"
    links:
      - database
      - cache
    depends_on:
      database:
        condition: service_healthy
    volumes:
      - cardinals_var:/app/var/
      - cardinals_nginx:/etc/nginx/http.d/
      - cardinals_certs:/etc/letsencrypt/
      - cardinals_logs:/app/storage/logs
      - ./panel/resources/views:/app/resources/views:ro
      - ./panel/resources/lang:/app/resources/lang:ro
    environment:
      <<: [*panel-environment, *mail-environment]
      DB_PASSWORD: *db-password
      APP_ENV: "production"
      APP_ENVIRONMENT_ONLY: "false"
      CACHE_DRIVER: "redis"
      SESSION_DRIVER: "redis"
      QUEUE_DRIVER: "redis"
      REDIS_HOST: "cache"
      DB_HOST: "database"
      DB_PORT: "3306"
      HASHIDS_LENGTH: 8

volumes:
  cardinals_db:
  cardinals_var:
  cardinals_nginx:
  cardinals_certs:
  cardinals_logs:

networks:
  default:
    driver: bridge
    ipam:
      config:
        - subnet: 172.21.0.0/16
COMPOSE
}

# ── Main ─────────────────────────────────────────────────────────────────────

main() {
  echo ""
  echo -e "${CYAN}  🐦  Cardinals Panel Installer${NC}"
  echo -e "${CYAN}  ─────────────────────────${NC}"
  echo ""

  check_deps
  check_wsl

  mkdir -p "$EAGLE_DIR"
  cd "$EAGLE_DIR"

  clone_or_pull "pterodactyl/panel" "$REPO_BASE/panel.git" "./panel"
  clone_or_pull "pterodactyl/wings" "$REPO_BASE/wings.git" "./wings"

  rebrand
  write_compose

  info "Pulling Docker images (this may take a minute)..."
  docker compose pull --quiet

  info "Starting Cardinals Panel..."
  docker compose up -d

  echo ""
  success "Cardinals Panel is running!"
  echo ""
  echo -e "  ${CYAN}Panel URL:${NC}   http://localhost"
  echo -e "  ${CYAN}Directory:${NC}   $EAGLE_DIR"
  echo ""
  echo -e "  ${YELLOW}Next steps:${NC}"
  echo -e "   1. Wait ~30s for the panel to initialize"
  echo -e "   2. Create your admin user:"
  echo -e "      ${CYAN}docker compose -f $EAGLE_DIR/docker-compose.yml exec panel php artisan p:user:make${NC}"
  echo -e "   3. Open http://localhost in your browser"
  echo ""
  echo -e "  ${YELLOW}Useful commands:${NC}"
  echo -e "   Stop:    docker compose -f $EAGLE_DIR/docker-compose.yml down"
  echo -e "   Logs:    docker compose -f $EAGLE_DIR/docker-compose.yml logs -f panel"
  echo -e "   Restart: docker compose -f $EAGLE_DIR/docker-compose.yml restart"
  echo ""
}

main "$@"
