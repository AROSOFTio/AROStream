# AROStream

Multi-tenant control panel for Icecast streaming stations. This repo includes the admin panel, tenant dashboard, and go-live workflow.

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+ (optional for Vite build)
- MySQL or SQLite
- aaPanel (for production hosting on Contabo)

## Local Setup (Windows)
```powershell
cd d:\programing\laravel\arostream\AROStream_skel
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Login:
- admin@arosoft.io / password

## Production on Contabo (aaPanel)

### 1) Server Prep
```bash
sudo apt update
sudo apt install -y curl unzip git
```

### 2) Install aaPanel
```bash
curl -sSO http://www.aapanel.com/script/install_6.0_en.sh
sudo bash install_6.0_en.sh
```
Open the aaPanel URL shown after install.

### 3) Create Site for Laravel
In aaPanel:
1. Website -> Add site
2. Domain: `panel.bentechs.com` (or your control panel domain)
3. Root: `/www/wwwroot/arostream`
4. PHP version: 8.2

Upload your project to `/www/wwwroot/arostream` and run:
```bash
cd /www/wwwroot/arostream
composer install --no-dev
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Set correct permissions:
```bash
chown -R www:www /www/wwwroot/arostream
chmod -R 775 /www/wwwroot/arostream/storage /www/wwwroot/arostream/bootstrap/cache
```

### 4) aaPanel Nginx config (Laravel)
Set site root to `/www/wwwroot/arostream/public`.

### 5) Queue + Scheduler (aaPanel)
Use aaPanel -> Cron:
- `* * * * * php /www/wwwroot/arostream/artisan schedule:run >> /dev/null 2>&1`
- Queue worker: `php /www/wwwroot/arostream/artisan queue:work --sleep=3 --tries=3`

## Icecast Streaming Setup (Contabo + Cloudflare)

### 1) DNS (Cloudflare)
Create A record:
- Name: `stream`
- Content: `95.111.234.34`
- Proxy: **DNS only (gray cloud)**

### 2) Install Icecast
```bash
sudo apt install -y icecast2
```
During install:
- Enable Icecast: Yes
- Hostname: `stream.bentechs.com`
- Set source / relay / admin passwords

### 3) Icecast config
Edit `/etc/icecast2/icecast.xml`:
```xml
<hostname>stream.bentechs.com</hostname>
<listen-socket>
  <port>8000</port>
</listen-socket>
```
Restart:
```bash
sudo systemctl restart icecast2
sudo systemctl enable icecast2
```

### 4) HTTPS on 443 (recommended)
Use aaPanel Nginx reverse proxy:
1. Create a new site `stream.bentechs.com`
2. Enable SSL (Let's Encrypt)
3. Add reverse proxy:
   - Target: `http://127.0.0.1:8000`

### 5) Firewall
```bash
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable
```

### 6) Test Icecast
Open:
```
https://stream.bentechs.com
```

## Configure the App for Streaming
In Admin -> Settings:
- Stream Public Host: `stream.bentechs.com`
- Stream Port: `443`
- Source Username: `source`

## Go Live (BUTT)
Use the Go Live page for each station. Encoder values shown there should match:
- Server: `stream.bentechs.com`
- Port: `443`
- Mount: `/live`
- Username: `source`
- Password: Icecast source password

Public listener URL:
```
https://stream.bentechs.com/live
```

## Notes
- Cloudflare proxy must be DNS-only for streaming.
- If you change to `stream.radioetoil.com`, update DNS and app settings.
- The web app is the control panel; Icecast handles audio streaming.
