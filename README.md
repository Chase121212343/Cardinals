# Cardinals Panel

A game server management panel forked from [Pterodactyl](https://pterodactyl.io), rebranded as Cardinals with a cardinal red & black theme.

## One-line install

```bash
curl -fsSL https://raw.githubusercontent.com/Chase121212343/Cardinals/main/install.sh | bash
```

Or if you already have this repo cloned:

```bash
bash install.sh
```

## Prerequisites

- **Linux** or **WSL2** on Windows 10/11
- **Docker** (the install script will install it if missing)
- For WSL2: **Docker Desktop** with WSL2 integration enabled

## What it installs

| Component | Details |
|-----------|---------|
| Cardinals Panel | PHP/Laravel + React UI |
| Database | MariaDB 11 |
| Cache | Redis |
| Wings | Go daemon (separate, manages game server containers) |

## After install

1. Wait ~30 seconds for the panel to initialize
2. Create your admin account:
   ```bash
   docker compose exec panel php artisan p:user:make --email=you@example.com --username=admin --name-first=Admin --name-last=User --password=YourPass1 --admin=1
   ```
3. Open **http://localhost** in your browser

## Wings setup (required to create servers)

After the panel is running, install Wings on the same machine:

```bash
curl -L https://github.com/pterodactyl/wings/releases/latest/download/wings_linux_amd64 -o /tmp/wings
chmod +x /tmp/wings && sudo mv /tmp/wings /usr/local/bin/wings
sudo mkdir -p /etc/pterodactyl /var/lib/pterodactyl/volumes
```

Then grab your node config from **Admin → Nodes → your node → Configuration tab** and paste it into `/etc/pterodactyl/config.yml`, then run:

```bash
sudo wings
```

## Useful commands

```bash
# Start
docker compose up -d

# Stop
docker compose down

# View logs
docker compose logs -f panel

# Restart panel
docker compose restart panel
```

## Updating

```bash
git -C panel pull
bash rebrand.sh ./panel ./wings
docker compose restart panel
```

## License

Cardinals Panel is a fork of Pterodactyl, which is licensed under the [MIT License](https://github.com/pterodactyl/panel/blob/develop/LICENSE.md).
