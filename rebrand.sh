#!/usr/bin/env bash
# Rebrands cloned Pterodactyl panel/wings repos to "Cardinals"
set -e

PANEL_DIR="${1:-./panel}"
WINGS_DIR="${2:-./wings}"

echo "🐦 Rebranding Pterodactyl → Cardinals..."

rebrand_file() {
  local f="$1"
  # Text replacements (preserve PHP namespace casing separately)
  sed -i \
    -e 's/Pterodactyl Panel/Cardinals Panel/g' \
    -e 's/pterodactyl\.io/cardinals\.local/g' \
    -e 's/https:\/\/pterodactyl\.io/https:\/\/github.com\/cardinals-panel\/cardinals/g' \
    -e 's/Pterodactyl, Inc\./Cardinals Panel Contributors/g' \
    "$f"
}

# --- Panel UI / views ---
echo "  Patching views..."
while IFS= read -r -d '' f; do
  sed -i \
    -e 's/>Pterodactyl</>Cardinals</g' \
    -e 's/Pterodactyl Panel/Cardinals Panel/g' \
    -e 's/Pterodactyl | /Cardinals | /g' \
    -e 's/pterodactyl\.io/cardinals\.panel/g' \
    "$f"
done < <(find "$PANEL_DIR/resources/views" -type f -name "*.php" -print0)

# --- Frontend React/TS ---
echo "  Patching frontend scripts..."
while IFS= read -r -d '' f; do
  sed -i \
    -e "s/'Pterodactyl'/'Cardinals'/g" \
    -e 's/"Pterodactyl"/"Cardinals"/g' \
    -e 's/Pterodactyl Panel/Cardinals Panel/g' \
    -e 's/pterodactyl\.io/cardinals\.panel/g' \
    "$f"
done < <(find "$PANEL_DIR/resources/scripts" -type f \( -name "*.tsx" -o -name "*.ts" -o -name "*.js" \) -print0)

# --- Lang strings ---
echo "  Patching language files..."
sed -i "s/Pterodactyl/Cardinals/g" "$PANEL_DIR/resources/lang/en/strings.php" 2>/dev/null || true
sed -i "s/Pterodactyl/Cardinals/g" "$PANEL_DIR/resources/lang/en/validation.php" 2>/dev/null || true

# --- config/app.php: change display name only, keep PHP namespace ---
echo "  Patching app config..."
sed -i "s/'name' => env('APP_NAME', 'Pterodactyl')/'name' => env('APP_NAME', 'Cardinals')/" \
  "$PANEL_DIR/config/app.php"

# --- composer.json: package name ---
sed -i 's/"name": "pterodactyl\/panel"/"name": "cardinals-panel\/cardinals"/' \
  "$PANEL_DIR/composer.json"

# --- Wings: display strings only (keep Go package paths intact) ---
echo "  Patching Wings display strings..."
sed -i \
  -e 's/Pterodactyl Wings/Cardinals Wings/g' \
  -e 's/pterodactyl\.io/cardinals\.panel/g' \
  "$WINGS_DIR/README.md" 2>/dev/null || true

echo "✅ Rebrand complete."
