<?php

namespace Helpers;
class DataGenerator
{
    public static $firstnameDs = array(
        'Johnathon',
        'Anthony',
        'Erasmo',
        'Raleigh',
        'Nancie',
        'Tama',
        'Camellia',
        'Augustine',
        'Christeen',
        'Luz',
        'Diego',
        'Lyndia',
        'Thomas',
        'Georgianna',
        'Leigha',
        'Alejandro',
        'Marquis',
        'Joan',
        'Stephania',
        'Elroy',
        'Zonia',
        'Buffy',
        'Sharie',
        'Blythe',
        'Gaylene',
        'Elida',
        'Randy',
        'Margarete',
        'Margarett',
        'Dion',
        'Tomi',
        'Arden',
        'Clora',
        'Laine',
        'Becki',
        'Margherita',
        'Bong',
        'Jeanice',
        'Qiana',
        'Lawanda',
        'Rebecka',
        'Maribel',
        'Tami',
        'Yuri',
        'Michele',
        'Rubi',
        'Larisa',
        'Lloyd',
        'Tyisha',
        'Samatha',
        // and so on
    );
    public static $lastnameDs = array(
        'Mischke',
        'Serna',
        'Pingree',
        'Mcnaught',
        'Pepper',
        'Schildgen',
        'Mongold',
        'Wrona',
        'Geddes',
        'Lanz',
        'Fetzer',
        'Schroeder',
        'Block',
        'Mayoral',
        'Fleishman',
        'Roberie',
        'Latson',
        'Lupo',
        'Motsinger',
        'Drews',
        'Coby',
        'Redner',
        'Culton',
        'Howe',
        'Stoval',
        'Michaud',
        'Mote',
        'Menjivar',
        'Wiers',
        'Paris',
        'Grisby',
        'Noren',
        'Damron',
        'Kazmierczak',
        'Haslett',
        'Guillemette',
        'Buresh',
        'Center',
        'Kucera',
        'Catt',
        'Badon',
        'Grumbles',
        'Antes',
        'Byron',
        'Volkman',
        'Klemp',
        'Pekar',
        'Pecora',
        'Schewe',
        'Ramage',
    );

    public static function FakeNameAndSurname(): string
    {
        $name = self::$firstnameDs[rand(0, count(self::$firstnameDs) - 1)];
        $name .= ' ';
        $name .= self::$lastnameDs[rand(0, count(self::$lastnameDs) - 1)];

        return $name;
    }

    public static function FakeMail(): string
    {
        $name = self::$firstnameDs[rand(0, count(self::$firstnameDs) - 1)];
        $name .= self::$lastnameDs[rand(0, count(self::$lastnameDs) - 1)];

        return "$name@mail.com";
    }

    public static function MailConvert(string $name): string
    {
        $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        return "$name@mail.com";
    }

    public static function DataSourceGenerate(int $count = 25): array
    {
        $ds = array();
        for ($i = 1; $i <= $count; $i++) {
            $name = DataGenerator::FakeNameAndSurname();
            array_push($ds, array(
                "Id" => "$i",
                "Email" => DataGenerator::MailConvert($name),
                "FullName" => $name
            ));
        }
        return $ds;
    }
}