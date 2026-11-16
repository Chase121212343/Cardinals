<div align="center">

# 🐦 Cardinals Panel

**A custom game server management panel built for performance.**  
Fork of [Pterodactyl](https://pterodactyl.io) — rebranded, rethemed, and ready to deploy.

![Cardinals Theme](https://img.shields.io/badge/theme-Cardinal%20Red%20%26%20Black-CC0000?style=for-the-badge)
![Docker](https://img.shields.io/badge/docker-ready-2496ED?style=for-the-badge&logo=docker)
![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)
![Platform](https://img.shields.io/badge/platform-Linux%20%7C%20WSL2-lightgrey?style=for-the-badge)

</div>

---

## ✨ Features

- 🔴 **Custom cardinal red & black theme** — dark UI with red accents throughout
- 🐦 **Cardinals branding** — custom cardinal bird logo, no Pterodactyl references
- 🐳 **One-line Docker install** — up and running in minutes
- 🐧 **Linux & WSL2 support** — works on any modern Linux or Windows WSL2
- 🎮 **Full game server support** — Minecraft, CS:GO, Rust, TF2, ARK, and more
- ⚡ **Auto-setup** — installs Docker, pulls images, configures everything automatically

---

## 🚀 One-Line Install

```bash
curl -fsSL https://raw.githubusercontent.com/Chase121212343/Cardinals/main/install.sh | bash
```

> Works on **Ubuntu, Debian, and WSL2**. Installs Docker automatically if not present.

---

## 📋 Requirements

| Requirement | Details |
|-------------|---------|
| OS | Ubuntu 20.04+ / Debian 11+ / WSL2 |
| RAM | 1GB minimum, 2GB recommended |
| Disk | 10GB minimum |
| Docker | Installed automatically if missing |

---

## ⚙️ After Install

**1. Create your admin account:**
```bash
docker compose -f ~/eagle/docker-compose.yml exec panel php artisan p:user:make \
  --email=you@example.com \
  --username=admin \
  --name-first=Admin \
  --name-last=User \
  --password=YourPass1 \
  --admin=1
```

**2. Open the panel:**
```
http://localhost
```

---

## 🖥️ Wings (Game Server Daemon)

Wings is required to actually run game servers. Install it on the same machine:

```bash
curl -L https://github.com/pterodactyl/wings/releases/latest/download/wings_linux_amd64 -o /tmp/wings
chmod +x /tmp/wings && sudo mv /tmp/wings /usr/local/bin/wings
sudo mkdir -p /etc/pterodactyl /var/lib/pterodactyl/volumes
```

Then grab your node config from **Admin → Nodes → your node → Configuration tab**, save it to `/etc/pterodactyl/config.yml`, and run:

```bash
sudo wings
```

---

## 🛠️ Useful Commands

```bash
# Start Cardinals
docker compose -f ~/eagle/docker-compose.yml up -d

# Stop Cardinals
docker compose -f ~/eagle/docker-compose.yml down

# View logs
docker compose -f ~/eagle/docker-compose.yml logs -f panel

# Restart
docker compose -f ~/eagle/docker-compose.yml restart panel
```

---

## 🔄 Updating

```bash
cd ~/eagle
git pull
git -C panel pull
bash rebrand.sh ./panel ./wings
docker compose -f ~/eagle/docker-compose.yml restart panel
```

---

## 📦 What Gets Installed

| Service | Image |
|---------|-------|
| Cardinals Panel | `ghcr.io/pterodactyl/panel:latest` |
| Database | `mariadb:11` |
| Cache | `redis:alpine` |

---

## 📄 License

Cardinals Panel is a fork of [Pterodactyl Panel](https://github.com/pterodactyl/panel), licensed under the [MIT License](LICENSE.md).

---

<div align="center">
  <sub>Built with ❤️ — Cardinals Panel</sub>
</div>
