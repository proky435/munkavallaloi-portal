# 🚀 Munkavállalói Portál - Fejlesztői Útmutató

## 📋 Projekt Összefoglaló

**Projekt neve:** munkavallaloi-portal  
**Verzió:** 2.0  
**Elsődleges nyelv:** Magyar (hu)  
**Framework:** Laravel 10.x  
**UI Framework:** Tailwind CSS + Alpine.js  

## 🎯 Főbb Funkciók

### ✅ Befejezett Rendszerek

1. **Felhasználói Rendszer**
   - Laravel Breeze alapú hitelesítés
   - Szerepkör-alapú jogosultságkezelés (RBAC)
   - Kiterjesztett profil kezelés

2. **Munkahely Rendszer**
   - Többszörös munkahely hozzárendelés
   - Időzített munkahely váltások
   - Dashboard figyelmeztetések

3. **Jegy/Bejelentés Rendszer**
   - 7 kategória dinamikus űrlapokkal
   - Fájl csatolás
   - Admin válaszok és beszélgetések

4. **Többnyelvűség**
   - Magyar, Angol, Spanyol
   - 220+ fordítási kulcs
   - Laravel lokalizáció

## 🛠️ Technológiai Stack

### Backend
- **Laravel 10.x** - PHP framework
- **MySQL 8.0+** - Adatbázis
- **Laravel Breeze** - Hitelesítés
- **Eloquent ORM** - Adatbázis kezelés

### Frontend
- **Blade Templates** - View engine
- **Tailwind CSS** - CSS framework
- **Alpine.js** - JavaScript framework
- **Vite** - Asset bundling

### Fejlesztői Eszközök
- **Composer** - PHP dependency manager
- **NPM** - JavaScript package manager
- **Laravel Artisan** - CLI tool
- **Git** - Verziókezelés

## 📁 Projekt Struktúra

```
munkavallaloi-portal/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin kontrollerek
│   │   │   ├── Auth/            # Hitelesítés
│   │   │   └── User/            # Felhasználói kontrollerek
│   │   ├── Middleware/          # Middleware-ek
│   │   └── Requests/            # Form validációk
│   ├── Models/                  # Eloquent modellek
│   │   ├── User.php
│   │   ├── Workplace.php
│   │   ├── UserWorkplace.php
│   │   ├── Ticket.php
│   │   ├── Category.php
│   │   └── Role.php
│   └── Services/                # Üzleti logika
├── database/
│   ├── migrations/              # Adatbázis migrációk
│   └── seeders/                 # Alapadatok
├── resources/
│   ├── views/                   # Blade template-ek
│   │   ├── admin/               # Admin felület
│   │   ├── auth/                # Hitelesítési oldalak
│   │   ├── components/          # Újrafelhasználható komponensek
│   │   └── layouts/             # Layout template-ek
│   ├── lang/                    # Fordítások
│   │   ├── hu/                  # Magyar
│   │   ├── en/                  # Angol
│   │   └── es/                  # Spanyol
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                  # Webes útvonalak
│   └── admin.php                # Admin útvonalak
├── config/                      # Konfigurációs fájlok
├── storage/                     # Fájl tárolás
└── public/                      # Publikus fájlok
```

## 🗄️ Adatbázis Séma

### Főbb Táblák

#### `users` - Felhasználók
```sql
- id (bigint, primary key)
- name (varchar)
- email (varchar, unique)
- role_id (bigint, foreign key)
- phone (varchar, nullable)
- birth_date (date, nullable)
- birth_place (varchar, nullable)
- address (varchar, nullable)
- city (varchar, nullable)
- postal_code (varchar, nullable)
- country (varchar, nullable)
- bank_account_number (varchar, nullable)
- tax_number (varchar, nullable)
- social_security_number (varchar, nullable)
- emergency_contact_name (varchar, nullable)
- emergency_contact_phone (varchar, nullable)
- created_at, updated_at
```

#### `user_workplaces` - Munkahely Hozzárendelések
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key)
- workplace_id (bigint, foreign key)
- start_date (date)
- end_date (date, nullable)
- is_primary (boolean, default false)
- is_permanent (boolean, default false)
- is_active (boolean, default true)
- notes (text, nullable)
- created_at, updated_at
```

#### `tickets` - Bejelentések
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key)
- category_id (bigint, foreign key)
- title (varchar)
- content (text)
- form_data (json, nullable)
- attachment_path (varchar, nullable)
- status (enum: new, in_progress, closed)
- created_at, updated_at
```

## 🔧 Telepítési Útmutató

### Előfeltételek
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

### Telepítési Lépések

1. **Repository klónozása**
```bash
git clone [repository-url]
cd munkavallaloi-portal
```

2. **Függőségek telepítése**
```bash
composer install
npm install
```

3. **Környezeti változók beállítása**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Adatbázis konfiguráció (.env fájlban)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=munkavallaloi_portal
DB_USERNAME=root
DB_PASSWORD=your_password

APP_LOCALE=hu
APP_FALLBACK_LOCALE=en
```

5. **Adatbázis migrációk és seeding**
```bash
php artisan migrate
php artisan db:seed
```

6. **Asset build**
```bash
npm run build
# vagy fejlesztéshez:
npm run dev
```

7. **Szerver indítása**
```bash
php artisan serve
```

## 👥 Szerepkörök és Jogosultságok

### Szerepkör Hierarchia

1. **super_admin** - Teljes rendszer hozzáférés
2. **admin** - Általános admin funkciók, kategória korlátozásokkal
3. **hr_admin** - HR specifikus funkciók (Fizetés, Adatváltozás kategóriák)
4. **finance_admin** - Pénzügyi funkciók (Fizetés, Utalás kategóriák)
5. **user** - Alapvető felhasználói funkciók

### Jogosultság Ellenőrzés

```php
// Middleware használata
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin útvonalak
});

// Blade template-ben
@can('manage_tickets')
    <!-- Admin funkciók -->
@endcan

// Controller-ben
if (auth()->user()->hasPermission('manage_all_tickets')) {
    // Jogosultság alapú logika
}
```

## 🌍 Többnyelvűség Kezelése

### Fordítási Fájlok

**JSON fájlok** (egyszerű kulcs-érték párok):
- `resources/lang/hu.json`
- `resources/lang/en.json`
- `resources/lang/es.json`

**PHP fájlok** (Laravel rendszer üzenetek):
- `resources/lang/hu/auth.php`
- `resources/lang/hu/validation.php`
- `resources/lang/hu/passwords.php`
- `resources/lang/hu/pagination.php`

### Használat

```php
// Blade template-ben
{{ __('Üdvözöljük!') }}

// Controller-ben
return redirect()->with('success', __('Sikeres mentés!'));

// Validációban
'name' => 'required|string|max:255',
```

### Új Fordítás Hozzáadása

1. Kulcs hozzáadása mindhárom JSON fájlhoz
2. View cache törlése: `php artisan view:clear`
3. Tesztelés minden nyelven

## 🎨 UI/UX Fejlesztés

### Design Rendszer

**Színpaletta:**
- Elsődleges: `#3B82F6` (blue-500)
- Másodlagos: `#10B981` (emerald-500)
- Figyelmeztetés: `#F59E0B` (amber-500)
- Hiba: `#EF4444` (red-500)

**Glassmorphism Stílus:**
```css
.glass-effect {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
}
```

### Responsive Breakpoints
- Mobile: `< 768px`
- Tablet: `768px - 1024px`
- Desktop: `> 1024px`

## 🔌 API Végpontok

### Felhasználói Útvonalak
```php
// Publikus
GET  /login                    # Bejelentkezési oldal
POST /login                    # Bejelentkezés
GET  /register                 # Regisztrációs oldal
POST /register                 # Regisztráció

// Hitelesített felhasználók
GET  /dashboard                # Dashboard
GET  /profile                  # Profil oldal
PUT  /profile                  # Profil frissítése
GET  /tickets                  # Saját jegyek
POST /tickets                  # Új jegy létrehozása
GET  /tickets/{id}             # Jegy részletei
```

### Admin Útvonalak
```php
// Admin dashboard
GET  /admin                    # Admin főoldal

// Felhasználó kezelés
GET  /admin/users              # Felhasználók listája
GET  /admin/users/{id}/edit    # Felhasználó szerkesztése
PUT  /admin/users/{id}         # Felhasználó frissítése

// Munkahely hozzárendelések
GET  /admin/user-workplaces    # Hozzárendelések listája
GET  /admin/user-workplaces/{user}/show  # Felhasználó munkahelyei
POST /admin/user-workplaces/{user}/transition  # Gyors váltás

// Jegy kezelés
GET  /admin/tickets            # Admin jegyek
PUT  /admin/tickets/{id}       # Jegy frissítése
POST /admin/tickets/{id}/reply # Válasz küldése
```

## 🧪 Tesztelés

### Manuális Tesztelési Checklist

**Felhasználói Funkciók:**
- [ ] Bejelentkezés/kijelentkezés
- [ ] Profil szerkesztése
- [ ] Új jegy létrehozása minden kategóriában
- [ ] Fájl csatolás (ahol engedélyezett)
- [ ] Nyelvváltás működése

**Admin Funkciók:**
- [ ] Felhasználók kezelése
- [ ] Szerepkör hozzárendelés
- [ ] Munkahely hozzárendelések
- [ ] Jegy válaszok
- [ ] Kategória szűrés

**Responsive Tesztelés:**
- [ ] Mobil nézet (< 768px)
- [ ] Tablet nézet (768-1024px)
- [ ] Desktop nézet (> 1024px)

## 🚨 Hibaelhárítás

### Gyakori Problémák

**1. Fordítások nem jelennek meg**
```bash
php artisan view:clear
php artisan config:clear
```

**2. Asset fájlok nem töltődnek be**
```bash
npm run build
php artisan storage:link
```

**3. Adatbázis kapcsolódási hiba**
- Ellenőrizd a `.env` fájl DB beállításait
- Győződj meg róla, hogy a MySQL szerver fut

**4. Jogosultság hibák**
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

## 📈 Jövőbeli Fejlesztések

### Tervezett Funkciók

1. **Adatváltozás Feldolgozó Rendszer**
   - Jóváhagyott adatváltozások automatikus alkalmazása
   - Audit trail minden változásról

2. **Email Értesítések**
   - Automatikus email küldés kategóriák szerint
   - Felhasználói értesítések státusz változásokról

3. **Tudásbázis Bővítése**
   - Kereshető cikkek
   - Kategorizált tartalmak
   - FAQ rendszer

4. **Mobil Alkalmazás**
   - React Native vagy Flutter alapú
   - Push értesítések
   - Offline funkciók

## 🔒 Biztonsági Megfontolások

### Implementált Biztonsági Intézkedések

1. **Hitelesítés és Jogosultságok**
   - Laravel Breeze alapú hitelesítés
   - CSRF védelem minden form-on
   - Szerepkör-alapú hozzáférés-vezérlés

2. **Adatvédelem**
   - Érzékeny adatok titkosítása
   - GDPR kompatibilis adatkezelés
   - Felhasználói beleegyezések

3. **Fájl Biztonság**
   - Fájl típus validáció
   - Biztonságos fájl tárolás
   - Vírus ellenőrzés (jövőbeli fejlesztés)

### Ajánlott Biztonsági Gyakorlatok

1. **Production Környezet**
   - SSL tanúsítvány használata
   - Rendszeres biztonsági frissítések
   - Erős jelszó szabályok

2. **Adatbázis Biztonság**
   - Rendszeres backup-ok
   - Adatbázis titkosítás
   - Hozzáférési jogok korlátozása

## 📞 Támogatás és Kapcsolat

### Fejlesztői Dokumentáció
- Laravel: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Alpine.js: https://alpinejs.dev/

### Projekt Specifikus Információk
- **Elsődleges nyelv:** Magyar
- **Kódolás:** UTF-8
- **Időzóna:** Europe/Budapest
- **Verziókezelés:** Git

---

**Utolsó frissítés:** 2025. szeptember 27.  
**Verzió:** 2.0  
**Státusz:** Aktív fejlesztés alatt
