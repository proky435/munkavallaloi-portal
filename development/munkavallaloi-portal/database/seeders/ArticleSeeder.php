<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Munkavállalói Portál Használati Útmutató',
                'slug' => 'munkavallaloi-portal-hasznalati-utmutato',
                'content' => 'Üdvözöljük a Munkavállalói Portálon!

Ez a portál az Ön számára készült, hogy könnyedén kezelhesse munkahelyi ügyeit és hozzáférjen a szükséges információkhoz.

FŐBB FUNKCIÓK:

1. DASHBOARD
- Gyors áttekintés a legfontosabb információkról
- Legutóbbi bejelentések és azok státusza
- Gyors műveletek elérése

2. BEJELENTÉSEK KEZELÉSE
- Új bejelentés létrehozása
- Meglévő bejelentések nyomon követése
- Válaszok és frissítések megtekintése

3. ADATVÁLTOZÁS BEJELENTÉS
- Személyes adatok módosításának kérelmezése
- Munkahely változás bejelentése
- Automatikus jóváhagyási folyamat

4. TUDÁSBÁZIS
- Hasznos információk és útmutatók
- Szabályzatok és eljárások
- Gyakran ismételt kérdések

5. PROFIL KEZELÉS
- Személyes adatok megtekintése és módosítása
- Jelszó változtatás
- Értesítési beállítások

TÁMOGATÁS:
Ha bármilyen kérdése van, használja a bejelentés funkciót vagy vegye fel a kapcsolatot az IT támogatással.',
                'is_published' => true,
            ],
            [
                'title' => 'Adatvédelmi Szabályzat',
                'slug' => 'adatvedelmi-szabalyzat',
                'content' => 'ADATVÉDELMI SZABÁLYZAT

1. ÁLTALÁNOS RENDELKEZÉSEK

A jelen adatvédelmi szabályzat célja, hogy tájékoztassa Önt arról, hogyan kezeljük az Ön személyes adatait a munkavállalói portál használata során.

2. ADATKEZELŐ AZONOSÍTÁSA

Adatkezelő: [Cég neve]
Székhely: [Cím]
Kapcsolat: [Email/telefon]

3. KEZELT ADATOK KÖRE

- Személyes azonosító adatok (név, születési dátum, hely)
- Kapcsolattartási adatok (email, telefon, cím)
- Munkahelyi adatok (beosztás, munkahely, belépési dátum)
- Rendszerhasználati adatok (bejelentkezési idők, műveletek)

4. ADATKEZELÉS JOGALAPJA

- Munkaviszonyból eredő kötelezettség teljesítése
- Jogos érdek (munkaszervezés, belső kommunikáció)
- Hozzájárulás (opcionális szolgáltatások esetén)

5. ADATOK TÁROLÁSI IDEJE

- Aktív munkaviszony alatt: folyamatos
- Munkaviszony megszűnése után: 5 év
- Különleges kategóriájú adatok: törvényi előírások szerint

6. ÖN JOGAI

- Tájékoztatáshoz való jog
- Helyesbítéshez való jog
- Törléshez való jog ("elfeledtetéshez való jog")
- Adatkezelés korlátozásához való jog
- Adathordozhatósághoz való jog
- Tiltakozáshoz való jog

7. ADATBIZTONSÁG

Technikai és szervezési intézkedéseket alkalmazunk az adatok védelme érdekében:
- Titkosított adattárolás
- Hozzáférés-vezérlés
- Rendszeres biztonsági mentések
- Munkatársi képzések

8. KAPCSOLAT

Adatvédelmi kérdésekkel kapcsolatban forduljon hozzánk bizalommal.',
                'is_published' => true,
            ],
            [
                'title' => 'Bejelentési Rendszer Használata',
                'slug' => 'bejelentesi-rendszer-hasznalata',
                'content' => 'BEJELENTÉSI RENDSZER HASZNÁLATI ÚTMUTATÓ

A bejelentési rendszer segítségével gyorsan és hatékonyan juttathatja el kéréseit, problémáit az illetékes kollégákhoz.

1. ÚJ BEJELENTÉS LÉTREHOZÁSA

Lépések:
1. Kattintson a "Saját bejelentéseim" menüpontra
2. Válassza az "Új bejelentés" gombot
3. Töltse ki a kötelező mezőket:
   - Kategória kiválasztása
   - Tárgy megadása
   - Részletes leírás
4. Csatoljon fájlokat, ha szükséges
5. Kattintson a "Bejelentés elküldése" gombra

2. KATEGÓRIÁK

- IT támogatás: számítógépes problémák, szoftver kérések
- HR: munkaügyi kérdések, szabadság, betegség
- Adminisztráció: irodai problémák, eszközök
- Egyéb: minden más típusú kérés

3. PRIORITÁSOK

- Alacsony: általános kérdések, nem sürgős kérések
- Közepes: munkavégzést befolyásoló problémák
- Magas: sürgős, munkavégzést akadályozó problémák

4. BEJELENTÉSEK NYOMON KÖVETÉSE

- Státusz változások automatikus értesítése
- Válaszok megtekintése
- További információk megadása

5. TIPPEK A HATÉKONY BEJELENTÉSHEZ

- Legyen konkrét és részletes
- Adja meg a pontos hibaüzenetet
- Csatoljon képernyőképeket, ha releváns
- Válassza ki a megfelelő kategóriát és prioritást

A bejelentések feldolgozási ideje kategóriától függően 1-3 munkanap.',
                'is_published' => true,
            ],
            [
                'title' => 'Adatváltozás Bejelentési Folyamat',
                'slug' => 'adatvaltozas-bejelentesi-folyamat',
                'content' => 'ADATVÁLTOZÁS BEJELENTÉSI FOLYAMAT

Ha személyes adataiban vagy munkahelyi információiban változás történt, ezt a portálon keresztül egyszerűen bejelentheti.

1. MIKOR SZÜKSÉGES ADATVÁLTOZÁS BEJELENTÉSE?

- Név változás (házasság, válás, névváltoztatás)
- Lakcím változás
- Telefonszám vagy email cím módosítása
- Bankszámlaszám változás
- Munkahely váltás
- Vészhelyzeti kapcsolattartó módosítása

2. BEJELENTÉSI FOLYAMAT

Lépések:
1. Navigáljon az "Adatváltozás bejelentés" menüpontra
2. Válassza ki a megfelelő változás típusát
3. Töltse ki az űrlapot a pontos adatokkal
4. Csatolja a szükséges dokumentumokat
5. Küldje el a kérelmet

3. SZÜKSÉGES DOKUMENTUMOK

Név változás:
- Anyakönyvi kivonat vagy házassági anyakönyvi kivonat
- Személyi igazolvány másolata

Lakcím változás:
- Lakcímkártya vagy lakcímigazolás
- Személyi igazolvány másolata

Bankszámlaszám változás:
- Bankszámla szerződés vagy bankigazolás

4. JÓVÁHAGYÁSI FOLYAMAT

- Automatikus ellenőrzés
- HR részleg jóváhagyása
- Értesítés a döntésről
- Adatok frissítése a rendszerben

5. ÜTEMEZETT VÁLTOZÁSOK

Lehetőség van jövőbeli dátumra ütemezett változások bejelentésére:
- Munkahely váltás előre meghatározott dátummal
- Automatikus emlékeztető küldése
- Pontos időben történő aktiválás

6. FONTOS TUDNIVALÓK

- A bejelentés nem jelenti az automatikus jóváhagyást
- Hiányos dokumentáció esetén visszaküldésre kerül
- A változások csak jóváhagyás után lépnek életbe
- Sürgős esetekben vegye fel a kapcsolatot a HR-rel

Kérdés esetén forduljon bizalommal a HR osztályhoz!',
                'is_published' => true,
            ],
            [
                'title' => 'Biztonságos Jelszó Létrehozása',
                'slug' => 'biztonsagos-jelszo-letrehozasa',
                'content' => 'BIZTONSÁGOS JELSZÓ LÉTREHOZÁSI ÚTMUTATÓ

A biztonságos jelszó használata elengedhetetlen a céges adatok védelme érdekében.

1. JELSZÓ KÖVETELMÉNYEK

Minimális követelmények:
- Legalább 8 karakter hosszú
- Tartalmaz nagybetűt (A-Z)
- Tartalmaz kisbetűt (a-z)
- Tartalmaz számot (0-9)
- Tartalmaz speciális karaktert (!@#$%^&*)

2. JAVASLATOK ERŐS JELSZÓHOZ

- Használjon 12-16 karakter hosszú jelszót
- Keverjen betűket, számokat és szimbólumokat
- Kerülje a személyes információkat (név, születési dátum)
- Ne használjon szótárban található szavakat
- Minden rendszerhez különböző jelszót használjon

3. JELSZÓ LÉTREHOZÁSI TECHNIKÁK

Mondatos módszer:
"A kedvenc könyvem címe: 1984" → AkkC:1984!

Helyettesítéses módszer:
"Szeretek sétálni" → Sz3r3t3kS3t4ln1!

Kezdőbetűs módszer:
"A macska 5 egeret fogott tegnap este 8-kor"
→ Am5eftE8k!

4. JELSZÓ KEZELÉS

- Soha ne ossza meg jelszavát másokkal
- Ne írja fel látható helyre
- Használjon jelszókezelő alkalmazást
- Rendszeresen változtassa meg (3-6 havonta)

5. KÉTFAKTOROS HITELESÍTÉS

Ha elérhető, mindig kapcsolja be:
- SMS kód
- Authenticator alkalmazás
- Email megerősítés

6. GYANÚS TEVÉKENYSÉG JELEI

Azonnal jelentse, ha:
- Ismeretlen bejelentkezési kísérleteket észlel
- Jelszava nem működik
- Gyanús emaileket kap

7. JELSZÓ VÁLTOZTATÁS A PORTÁLON

1. Jelentkezzen be a portálra
2. Menjen a Profil beállításokhoz
3. Válassza a "Jelszó változtatás" opciót
4. Adja meg a jelenlegi jelszót
5. Írja be az új jelszót kétszer
6. Kattintson a "Mentés" gombra

FONTOS: Az új jelszó azonnal életbe lép minden eszközön!',
                'is_published' => true,
            ]
        ];

        foreach ($articles as $articleData) {
            \App\Models\Article::create($articleData);
        }
    }
}
