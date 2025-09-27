# 🏢 Munkavállalói Portál - Dokumentáció

## 📁 Dokumentációs Fájlok

Ez a mappa tartalmazza a Munkavállalói Portál teljes dokumentációját:

### 📄 Fájlok

1. **[dokumentacio.html](./dokumentacio.html)** 
   - **Teljes HTML dokumentáció** modern design-nal
   - Böngészőben megnyitható, interaktív navigációval
   - Tartalmazza: projekt áttekintés, funkciók, telepítés, használat, admin útmutató

2. **[fejlesztoi-utmutato.md](./fejlesztoi-utmutato.md)**
   - **Fejlesztői útmutató** Markdown formátumban
   - Technikai részletek, kódpéldák, API dokumentáció
   - Hibaelhárítás és jövőbeli fejlesztési tervek

## 🚀 Gyors Áttekintés

### Projekt Információk
- **Név:** munkavallaloi-portal
- **Verzió:** 2.0
- **Elsődleges nyelv:** Magyar (hu)
- **Framework:** Laravel 10.x + Tailwind CSS
- **Támogatott nyelvek:** Magyar, Angol, Spanyol

### Főbb Funkciók ✅
- ✅ Szerepkör-alapú felhasználói rendszer
- ✅ Többszörös munkahely hozzárendelések
- ✅ Dinamikus jegy/bejelentés rendszer
- ✅ Teljes többnyelvűség (220+ fordítás)
- ✅ Modern glassmorphism UI design
- ✅ Responsive mobil támogatás

### Gyors Telepítés
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

### Alapértelmezett URL-ek
- **Felhasználói oldal:** http://localhost:8000
- **Admin felület:** http://localhost:8000/admin
- **Bejelentkezés:** http://localhost:8000/login

## 📖 Dokumentáció Használata

### HTML Dokumentáció Megnyitása
1. Nyisd meg a `dokumentacio.html` fájlt böngészőben
2. Használd a navigációs menüt a gyors ugráshoz
3. Minden szekció részletesen dokumentált

### Markdown Útmutató
- Fejlesztőknek szánt technikai információk
- GitHub-on vagy Markdown viewerben olvasható
- Kódpéldák és API referencia

## 🔧 Technológiai Stack

| Komponens | Technológia |
|-----------|-------------|
| Backend | Laravel 10.x, PHP 8.1+ |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Adatbázis | MySQL 8.0+ |
| Hitelesítés | Laravel Breeze |
| Asset Build | Vite |
| Lokalizáció | Laravel i18n |

## 👥 Szerepkörök

| Szerepkör | Jogosultságok |
|-----------|---------------|
| super_admin | Teljes rendszer hozzáférés |
| admin | Általános admin funkciók |
| hr_admin | HR specifikus kategóriák |
| finance_admin | Pénzügyi kategóriák |
| user | Alapvető felhasználói funkciók |

## 📊 Projekt Státusz

### Befejezett Funkciók (100%)
- [x] Felhasználói rendszer és hitelesítés
- [x] Szerepkör-alapú jogosultságkezelés
- [x] Munkahely rendszer többszörös hozzárendelésekkel
- [x] Jegy/bejelentés rendszer 7 kategóriával
- [x] Többnyelvűség (hu, en, es)
- [x] Modern responsive UI/UX
- [x] Admin felület teljes funkcionalitással

### Jövőbeli Fejlesztések
- [ ] Adatváltozás feldolgozó rendszer
- [ ] Email értesítések automatizálása
- [ ] Tudásbázis bővítése
- [ ] Mobil alkalmazás fejlesztése

## 🌐 Nyelvek

A rendszer teljes mértékben támogatja a következő nyelveket:

- 🇭🇺 **Magyar** (elsődleges)
- 🇬🇧 **Angol**
- 🇪🇸 **Spanyol**

Minden UI elem, hibaüzenet és validáció lokalizált.

## 📞 Támogatás

A dokumentáció bármely részével kapcsolatos kérdés esetén:

1. Nézd át a HTML dokumentációt részletes információkért
2. Ellenőrizd a fejlesztői útmutatót technikai részletekért
3. Használd a Laravel hivatalos dokumentációját: https://laravel.com/docs

---

**Utolsó frissítés:** 2025. szeptember 27.  
**Dokumentáció verzió:** 2.0  
**Projekt státusz:** ✅ Teljes funkcionalitás
