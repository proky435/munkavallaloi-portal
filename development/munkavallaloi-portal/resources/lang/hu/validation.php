<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'A :attribute mezőt el kell fogadni.',
    'accepted_if' => 'A :attribute mezőt el kell fogadni, amikor :other értéke :value.',
    'active_url' => 'A :attribute mezőnek érvényes URL-nek kell lennie.',
    'after' => 'A :attribute mezőnek :date utáni dátumnak kell lennie.',
    'after_or_equal' => 'A :attribute mezőnek :date utáni vagy azzal egyenlő dátumnak kell lennie.',
    'alpha' => 'A :attribute mező csak betűket tartalmazhat.',
    'alpha_dash' => 'A :attribute mező csak betűket, számokat, kötőjeleket és aláhúzásokat tartalmazhat.',
    'alpha_num' => 'A :attribute mező csak betűket és számokat tartalmazhat.',
    'any_of' => 'A :attribute mező érvénytelen.',
    'array' => 'A :attribute mezőnek tömbnek kell lennie.',
    'ascii' => 'A :attribute mező csak egybájtos alfanumerikus karaktereket és szimbólumokat tartalmazhat.',
    'before' => 'A :attribute mezőnek :date előtti dátumnak kell lennie.',
    'before_or_equal' => 'A :attribute mezőnek :date előtti vagy azzal egyenlő dátumnak kell lennie.',
    'between' => [
        'array' => 'A :attribute mezőnek :min és :max elem között kell lennie.',
        'file' => 'A :attribute mezőnek :min és :max kilobájt között kell lennie.',
        'numeric' => 'A :attribute mezőnek :min és :max között kell lennie.',
        'string' => 'A :attribute mezőnek :min és :max karakter között kell lennie.',
    ],
    'boolean' => 'A :attribute mezőnek igaz vagy hamis értékűnek kell lennie.',
    'can' => 'A :attribute mező jogosulatlan értéket tartalmaz.',
    'confirmed' => 'A :attribute mező megerősítése nem egyezik.',
    'contains' => 'A :attribute mezőből hiányzik egy kötelező érték.',
    'current_password' => 'A jelszó helytelen.',
    'date' => 'A :attribute mezőnek érvényes dátumnak kell lennie.',
    'date_equals' => 'A :attribute mezőnek :date dátummal egyenlőnek kell lennie.',
    'date_format' => 'A :attribute mezőnek meg kell egyeznie a :format formátummal.',
    'decimal' => 'A :attribute mezőnek :decimal tizedesjeggyel kell rendelkeznie.',
    'declined' => 'A :attribute mezőt el kell utasítani.',
    'declined_if' => 'A :attribute mezőt el kell utasítani, amikor :other értéke :value.',
    'different' => 'A :attribute mező és :other különbözőnek kell lennie.',
    'digits' => 'A :attribute mezőnek :digits számjegyűnek kell lennie.',
    'digits_between' => 'A :attribute mezőnek :min és :max számjegy között kell lennie.',
    'dimensions' => 'A :attribute mező érvénytelen képméretekkel rendelkezik.',
    'distinct' => 'A :attribute mező duplikált értékkel rendelkezik.',
    'doesnt_contain' => 'A :attribute mező nem tartalmazhatja a következők egyikét sem: :values.',
    'doesnt_end_with' => 'A :attribute mező nem végződhet a következők egyikével: :values.',
    'doesnt_start_with' => 'A :attribute mező nem kezdődhet a következők egyikével: :values.',
    'email' => 'A :attribute mezőnek érvényes e-mail címnek kell lennie.',
    'ends_with' => 'A :attribute mezőnek a következők egyikével kell végződnie: :values.',
    'enum' => 'A kiválasztott :attribute érvénytelen.',
    'exists' => 'A kiválasztott :attribute érvénytelen.',
    'extensions' => 'A :attribute mezőnek a következő kiterjesztések egyikével kell rendelkeznie: :values.',
    'file' => 'A :attribute mezőnek fájlnak kell lennie.',
    'filled' => 'A :attribute mezőnek értékkel kell rendelkeznie.',
    'gt' => [
        'array' => 'A :attribute mezőnek több mint :value elemmel kell rendelkeznie.',
        'file' => 'A :attribute mezőnek nagyobbnak kell lennie :value kilobájtnál.',
        'numeric' => 'A :attribute mezőnek nagyobbnak kell lennie :value-nál.',
        'string' => 'A :attribute mezőnek több mint :value karakterből kell állnia.',
    ],
    'gte' => [
        'array' => 'A :attribute mezőnek :value vagy több elemmel kell rendelkeznie.',
        'file' => 'A :attribute mezőnek nagyobb vagy egyenlőnek kell lennie :value kilobájtnál.',
        'numeric' => 'A :attribute mezőnek nagyobb vagy egyenlőnek kell lennie :value-val.',
        'string' => 'A :attribute mezőnek legalább :value karakterből kell állnia.',
    ],
    'hex_color' => 'A :attribute mezőnek érvényes hexadecimális színnek kell lennie.',
    'image' => 'A :attribute mezőnek képnek kell lennie.',
    'in' => 'A kiválasztott :attribute érvénytelen.',
    'in_array' => 'A :attribute mezőnek léteznie kell a :other-ben.',
    'in_array_keys' => 'A :attribute mezőnek tartalmaznia kell legalább egyet a következő kulcsok közül: :values.',
    'integer' => 'A :attribute mezőnek egész számnak kell lennie.',
    'ip' => 'A :attribute mezőnek érvényes IP címnek kell lennie.',
    'ipv4' => 'A :attribute mezőnek érvényes IPv4 címnek kell lennie.',
    'ipv6' => 'A :attribute mezőnek érvényes IPv6 címnek kell lennie.',
    'json' => 'A :attribute mezőnek érvényes JSON karakterláncnak kell lennie.',
    'list' => 'A :attribute mezőnek listának kell lennie.',
    'lowercase' => 'A :attribute mezőnek kisbetűsnek kell lennie.',
    'lt' => [
        'array' => 'A :attribute mezőnek kevesebb mint :value elemmel kell rendelkeznie.',
        'file' => 'A :attribute mezőnek kisebbnek kell lennie :value kilobájtnál.',
        'numeric' => 'A :attribute mezőnek kisebbnek kell lennie :value-nál.',
        'string' => 'A :attribute mezőnek kevesebb mint :value karakterből kell állnia.',
    ],
    'lte' => [
        'array' => 'A :attribute mező nem rendelkezhet több mint :value elemmel.',
        'file' => 'A :attribute mezőnek kisebb vagy egyenlőnek kell lennie :value kilobájtnál.',
        'numeric' => 'A :attribute mezőnek kisebb vagy egyenlőnek kell lennie :value-val.',
        'string' => 'A :attribute mezőnek legfeljebb :value karakterből kell állnia.',
    ],
    'mac_address' => 'A :attribute mezőnek érvényes MAC címnek kell lennie.',
    'max' => [
        'array' => 'A :attribute mező nem rendelkezhet több mint :max elemmel.',
        'file' => 'A :attribute mező nem lehet nagyobb :max kilobájtnál.',
        'numeric' => 'A :attribute mező nem lehet nagyobb :max-nál.',
        'string' => 'A :attribute mező nem lehet hosszabb :max karakternél.',
    ],
    'max_digits' => 'A :attribute mező nem rendelkezhet több mint :max számjeggyel.',
    'mimes' => 'A :attribute mezőnek a következő típusú fájlnak kell lennie: :values.',
    'mimetypes' => 'A :attribute mezőnek a következő típusú fájlnak kell lennie: :values.',
    'min' => [
        'array' => 'A :attribute mezőnek legalább :min elemmel kell rendelkeznie.',
        'file' => 'A :attribute mezőnek legalább :min kilobájtnak kell lennie.',
        'numeric' => 'A :attribute mezőnek legalább :min-nek kell lennie.',
        'string' => 'A :attribute mezőnek legalább :min karakterből kell állnia.',
    ],
    'min_digits' => 'A :attribute mezőnek legalább :min számjeggyel kell rendelkeznie.',
    'missing' => 'A :attribute mezőnek hiányoznia kell.',
    'missing_if' => 'A :attribute mezőnek hiányoznia kell, amikor :other értéke :value.',
    'missing_unless' => 'A :attribute mezőnek hiányoznia kell, kivéve ha :other értéke :value.',
    'missing_with' => 'A :attribute mezőnek hiányoznia kell, amikor :values jelen van.',
    'missing_with_all' => 'A :attribute mezőnek hiányoznia kell, amikor :values jelen vannak.',
    'multiple_of' => 'A :attribute mezőnek :value többszörösének kell lennie.',
    'not_in' => 'A kiválasztott :attribute érvénytelen.',
    'not_regex' => 'A :attribute mező formátuma érvénytelen.',
    'numeric' => 'A :attribute mezőnek számnak kell lennie.',
    'password' => [
        'letters' => 'A :attribute mezőnek legalább egy betűt kell tartalmaznia.',
        'mixed' => 'A :attribute mezőnek legalább egy nagy- és egy kisbetűt kell tartalmaznia.',
        'numbers' => 'A :attribute mezőnek legalább egy számot kell tartalmaznia.',
        'symbols' => 'A :attribute mezőnek legalább egy szimbólumot kell tartalmaznia.',
        'uncompromised' => 'A megadott :attribute adatszivárgásban szerepelt. Kérjük, válasszon másik :attribute-t.',
    ],
    'present' => 'A :attribute mezőnek jelen kell lennie.',
    'present_if' => 'A :attribute mezőnek jelen kell lennie, amikor :other értéke :value.',
    'present_unless' => 'A :attribute mezőnek jelen kell lennie, kivéve ha :other értéke :value.',
    'present_with' => 'A :attribute mezőnek jelen kell lennie, amikor :values jelen van.',
    'present_with_all' => 'A :attribute mezőnek jelen kell lennie, amikor :values jelen vannak.',
    'prohibited' => 'A :attribute mező tiltott.',
    'prohibited_if' => 'A :attribute mező tiltott, amikor :other értéke :value.',
    'prohibited_if_accepted' => 'A :attribute mező tiltott, amikor :other el van fogadva.',
    'prohibited_if_declined' => 'A :attribute mező tiltott, amikor :other el van utasítva.',
    'prohibited_unless' => 'A :attribute mező tiltott, kivéve ha :other a :values között van.',
    'prohibits' => 'A :attribute mező megtiltja, hogy :other jelen legyen.',
    'regex' => 'A :attribute mező formátuma érvénytelen.',
    'required' => 'A :attribute mező kötelező.',
    'required_array_keys' => 'A :attribute mezőnek tartalmaznia kell bejegyzéseket a következőkhöz: :values.',
    'required_if' => 'A :attribute mező kötelező, amikor :other értéke :value.',
    'required_if_accepted' => 'A :attribute mező kötelező, amikor :other el van fogadva.',
    'required_if_declined' => 'A :attribute mező kötelező, amikor :other el van utasítva.',
    'required_unless' => 'A :attribute mező kötelező, kivéve ha :other a :values között van.',
    'required_with' => 'A :attribute mező kötelező, amikor :values jelen van.',
    'required_with_all' => 'A :attribute mező kötelező, amikor :values jelen vannak.',
    'required_without' => 'A :attribute mező kötelező, amikor :values nincs jelen.',
    'required_without_all' => 'A :attribute mező kötelező, amikor :values egyike sincs jelen.',
    'same' => 'A :attribute mezőnek meg kell egyeznie :other-rel.',
    'size' => [
        'array' => 'A :attribute mezőnek :size elemet kell tartalmaznia.',
        'file' => 'A :attribute mezőnek :size kilobájtnak kell lennie.',
        'numeric' => 'A :attribute mezőnek :size-nak kell lennie.',
        'string' => 'A :attribute mezőnek :size karakterből kell állnia.',
    ],
    'starts_with' => 'A :attribute mezőnek a következők egyikével kell kezdődnie: :values.',
    'string' => 'A :attribute mezőnek karakterláncnak kell lennie.',
    'timezone' => 'A :attribute mezőnek érvényes időzónának kell lennie.',
    'unique' => 'A :attribute már foglalt.',
    'uploaded' => 'A :attribute feltöltése sikertelen.',
    'uppercase' => 'A :attribute mezőnek nagybetűsnek kell lennie.',
    'url' => 'A :attribute mezőnek érvényes URL-nek kell lennie.',
    'ulid' => 'A :attribute mezőnek érvényes ULID-nek kell lennie.',
    'uuid' => 'A :attribute mezőnek érvényes UUID-nek kell lennie.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
