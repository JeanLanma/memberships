<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Sistema suscripciones Laravel 9 Cashier Stripe

## Crear proyecto
```shell
laravel new cashier-memberships --dev
cd cashier-memberships
```

## Añadir Breeze
```shell
composer require laravel/breeze --dev
php artisan breeze:install
yarn && yarn watch
```

## Instalar Cashier
```shell
composer require laravel/cashier
```

## Generar base de datos
```shell
php artisan migrate
```

## Publicar configuración Cashier
```shell
php artisan vendor:publish --tag="cashier-config"
```

## Añadir Billable a modelo User
```php
use Billable;
```

## ¿Calcular tasas? AppServiceProvider -> boot
```php
Cashier::calculateTaxes();
```

## Crear cuenta Stripe y obtener claves
```dotenv
STRIPE_KEY=your-stripe-key
STRIPE_SECRET=your-stripe-secret
CASHIER_CURRENCY=eur
CASHIER_CURRENCY_LOCALE=es_ES
```

## Crear modelo y migración Country
```shell
php artisan make:model Country -m
```
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('phonecode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
```

```shell
php artisan make:seed CountrySeeder
```

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();
        $countries = array(
            array('id' => 1,'code' => 'AF' ,'name' => "Afghanistan",'phonecode' => 93),
            array('id' => 2,'code' => 'AL' ,'name' => "Albania",'phonecode' => 355),
            array('id' => 3,'code' => 'DZ' ,'name' => "Algeria",'phonecode' => 213),
            array('id' => 4,'code' => 'AS' ,'name' => "American Samoa",'phonecode' => 1684),
            array('id' => 5,'code' => 'AD' ,'name' => "Andorra",'phonecode' => 376),
            array('id' => 6,'code' => 'AO' ,'name' => "Angola",'phonecode' => 244),
            array('id' => 7,'code' => 'AI' ,'name' => "Anguilla",'phonecode' => 1264),
            array('id' => 8,'code' => 'AQ' ,'name' => "Antarctica",'phonecode' => 0),
            array('id' => 9,'code' => 'AG' ,'name' => "Antigua And Barbuda",'phonecode' => 1268),
            array('id' => 10,'code' => 'AR','name' => "Argentina",'phonecode' => 54),
            array('id' => 11,'code' => 'AM','name' => "Armenia",'phonecode' => 374),
            array('id' => 12,'code' => 'AW','name' => "Aruba",'phonecode' => 297),
            array('id' => 13,'code' => 'AU','name' => "Australia",'phonecode' => 61),
            array('id' => 14,'code' => 'AT','name' => "Austria",'phonecode' => 43),
            array('id' => 15,'code' => 'AZ','name' => "Azerbaijan",'phonecode' => 994),
            array('id' => 16,'code' => 'BS','name' => "Bahamas The",'phonecode' => 1242),
            array('id' => 17,'code' => 'BH','name' => "Bahrain",'phonecode' => 973),
            array('id' => 18,'code' => 'BD','name' => "Bangladesh",'phonecode' => 880),
            array('id' => 19,'code' => 'BB','name' => "Barbados",'phonecode' => 1246),
            array('id' => 20,'code' => 'BY','name' => "Belarus",'phonecode' => 375),
            array('id' => 21,'code' => 'BE','name' => "Belgium",'phonecode' => 32),
            array('id' => 22,'code' => 'BZ','name' => "Belize",'phonecode' => 501),
            array('id' => 23,'code' => 'BJ','name' => "Benin",'phonecode' => 229),
            array('id' => 24,'code' => 'BM','name' => "Bermuda",'phonecode' => 1441),
            array('id' => 25,'code' => 'BT','name' => "Bhutan",'phonecode' => 975),
            array('id' => 26,'code' => 'BO','name' => "Bolivia",'phonecode' => 591),
            array('id' => 27,'code' => 'BA','name' => "Bosnia and Herzegovina",'phonecode' => 387),
            array('id' => 28,'code' => 'BW','name' => "Botswana",'phonecode' => 267),
            array('id' => 29,'code' => 'BV','name' => "Bouvet Island",'phonecode' => 0),
            array('id' => 30,'code' => 'BR','name' => "Brazil",'phonecode' => 55),
            array('id' => 31,'code' => 'IO','name' => "British Indian Ocean Territory",'phonecode' => 246),
            array('id' => 32,'code' => 'BN','name' => "Brunei",'phonecode' => 673),
            array('id' => 33,'code' => 'BG','name' => "Bulgaria",'phonecode' => 359),
            array('id' => 34,'code' => 'BF','name' => "Burkina Faso",'phonecode' => 226),
            array('id' => 35,'code' => 'BI','name' => "Burundi",'phonecode' => 257),
            array('id' => 36,'code' => 'KH','name' => "Cambodia",'phonecode' => 855),
            array('id' => 37,'code' => 'CM','name' => "Cameroon",'phonecode' => 237),
            array('id' => 38,'code' => 'CA','name' => "Canada",'phonecode' => 1),
            array('id' => 39,'code' => 'CV','name' => "Cape Verde",'phonecode' => 238),
            array('id' => 40,'code' => 'KY','name' => "Cayman Islands",'phonecode' => 1345),
            array('id' => 41,'code' => 'CF','name' => "Central African Republic",'phonecode' => 236),
            array('id' => 42,'code' => 'TD','name' => "Chad",'phonecode' => 235),
            array('id' => 43,'code' => 'CL','name' => "Chile",'phonecode' => 56),
            array('id' => 44,'code' => 'CN','name' => "China",'phonecode' => 86),
            array('id' => 45,'code' => 'CX','name' => "Christmas Island",'phonecode' => 61),
            array('id' => 46,'code' => 'CC','name' => "Cocos (Keeling) Islands",'phonecode' => 672),
            array('id' => 47,'code' => 'CO','name' => "Colombia",'phonecode' => 57),
            array('id' => 48,'code' => 'KM','name' => "Comoros",'phonecode' => 269),
            array('id' => 49,'code' => 'CG','name' => "Congo",'phonecode' => 242),
            array('id' => 50,'code' => 'CD','name' => "Congo The Democratic Republic Of The",'phonecode' => 242),
            array('id' => 51,'code' => 'CK','name' => "Cook Islands",'phonecode' => 682),
            array('id' => 52,'code' => 'CR','name' => "Costa Rica",'phonecode' => 506),
            array('id' => 53,'code' => 'CI','name' => "Cote D Ivoire (Ivory Coast)",'phonecode' => 225),
            array('id' => 54,'code' => 'HR','name' => "Croatia (Hrvatska)",'phonecode' => 385),
            array('id' => 55,'code' => 'CU','name' => "Cuba",'phonecode' => 53),
            array('id' => 56,'code' => 'CY','name' => "Cyprus",'phonecode' => 357),
            array('id' => 57,'code' => 'CZ','name' => "Czech Republic",'phonecode' => 420),
            array('id' => 58,'code' => 'DK','name' => "Denmark",'phonecode' => 45),
            array('id' => 59,'code' => 'DJ','name' => "Djibouti",'phonecode' => 253),
            array('id' => 60,'code' => 'DM','name' => "Dominica",'phonecode' => 1767),
            array('id' => 61,'code' => 'DO','name' => "Dominican Republic",'phonecode' => 1809),
            array('id' => 62,'code' => 'TP','name' => "East Timor",'phonecode' => 670),
            array('id' => 63,'code' => 'EC','name' => "Ecuador",'phonecode' => 593),
            array('id' => 64,'code' => 'EG','name' => "Egypt",'phonecode' => 20),
            array('id' => 65,'code' => 'SV','name' => "El Salvador",'phonecode' => 503),
            array('id' => 66,'code' => 'GQ','name' => "Equatorial Guinea",'phonecode' => 240),
            array('id' => 67,'code' => 'ER','name' => "Eritrea",'phonecode' => 291),
            array('id' => 68,'code' => 'EE','name' => "Estonia",'phonecode' => 372),
            array('id' => 69,'code' => 'ET','name' => "Ethiopia",'phonecode' => 251),
            array('id' => 70,'code' => 'XA','name' => "External Territories of Australia",'phonecode' => 61),
            array('id' => 71,'code' => 'FK','name' => "Falkland Islands",'phonecode' => 500),
            array('id' => 72,'code' => 'FO','name' => "Faroe Islands",'phonecode' => 298),
            array('id' => 73,'code' => 'FJ','name' => "Fiji Islands",'phonecode' => 679),
            array('id' => 74,'code' => 'FI','name' => "Finland",'phonecode' => 358),
            array('id' => 75,'code' => 'FR','name' => "France",'phonecode' => 33),
            array('id' => 76,'code' => 'GF','name' => "French Guiana",'phonecode' => 594),
            array('id' => 77,'code' => 'PF','name' => "French Polynesia",'phonecode' => 689),
            array('id' => 78,'code' => 'TF','name' => "French Southern Territories",'phonecode' => 0),
            array('id' => 79,'code' => 'GA','name' => "Gabon",'phonecode' => 241),
            array('id' => 80,'code' => 'GM','name' => "Gambia The",'phonecode' => 220),
            array('id' => 81,'code' => 'GE','name' => "Georgia",'phonecode' => 995),
            array('id' => 82,'code' => 'DE','name' => "Germany",'phonecode' => 49),
            array('id' => 83,'code' => 'GH','name' => "Ghana",'phonecode' => 233),
            array('id' => 84,'code' => 'GI','name' => "Gibraltar",'phonecode' => 350),
            array('id' => 85,'code' => 'GR','name' => "Greece",'phonecode' => 30),
            array('id' => 86,'code' => 'GL','name' => "Greenland",'phonecode' => 299),
            array('id' => 87,'code' => 'GD','name' => "Grenada",'phonecode' => 1473),
            array('id' => 88,'code' => 'GP','name' => "Guadeloupe",'phonecode' => 590),
            array('id' => 89,'code' => 'GU','name' => "Guam",'phonecode' => 1671),
            array('id' => 90,'code' => 'GT','name' => "Guatemala",'phonecode' => 502),
            array('id' => 91,'code' => 'XU','name' => "Guernsey and Alderney",'phonecode' => 44),
            array('id' => 92,'code' => 'GN','name' => "Guinea",'phonecode' => 224),
            array('id' => 93,'code' => 'GW','name' => "Guinea-Bissau",'phonecode' => 245),
            array('id' => 94,'code' => 'GY','name' => "Guyana",'phonecode' => 592),
            array('id' => 95,'code' => 'HT','name' => "Haiti",'phonecode' => 509),
            array('id' => 96,'code' => 'HM','name' => "Heard and McDonald Islands",'phonecode' => 0),
            array('id' => 97,'code' => 'HN','name' => "Honduras",'phonecode' => 504),
            array('id' => 98,'code' => 'HK','name' => "Hong Kong S.A.R.",'phonecode' => 852),
            array('id' => 99,'code' => 'HU','name' => "Hungary",'phonecode' => 36),
            array('id' => 100,'code' => 'IS','name' => "Iceland",'phonecode' => 354),
            array('id' => 101,'code' => 'IN','name' => "India",'phonecode' => 91),
            array('id' => 102,'code' => 'ID','name' => "Indonesia",'phonecode' => 62),
            array('id' => 103,'code' => 'IR','name' => "Iran",'phonecode' => 98),
            array('id' => 104,'code' => 'IQ','name' => "Iraq",'phonecode' => 964),
            array('id' => 105,'code' => 'IE','name' => "Ireland",'phonecode' => 353),
            array('id' => 106,'code' => 'IL','name' => "Israel",'phonecode' => 972),
            array('id' => 107,'code' => 'IT','name' => "Italy",'phonecode' => 39),
            array('id' => 108,'code' => 'JM','name' => "Jamaica",'phonecode' => 1876),
            array('id' => 109,'code' => 'JP','name' => "Japan",'phonecode' => 81),
            array('id' => 110,'code' => 'XJ','name' => "Jersey",'phonecode' => 44),
            array('id' => 111,'code' => 'JO','name' => "Jordan",'phonecode' => 962),
            array('id' => 112,'code' => 'KZ','name' => "Kazakhstan",'phonecode' => 7),
            array('id' => 113,'code' => 'KE','name' => "Kenya",'phonecode' => 254),
            array('id' => 114,'code' => 'KI','name' => "Kiribati",'phonecode' => 686),
            array('id' => 115,'code' => 'KP','name' => "Korea North",'phonecode' => 850),
            array('id' => 116,'code' => 'KR','name' => "Korea South",'phonecode' => 82),
            array('id' => 117,'code' => 'KW','name' => "Kuwait",'phonecode' => 965),
            array('id' => 118,'code' => 'KG','name' => "Kyrgyzstan",'phonecode' => 996),
            array('id' => 119,'code' => 'LA','name' => "Laos",'phonecode' => 856),
            array('id' => 120,'code' => 'LV','name' => "Latvia",'phonecode' => 371),
            array('id' => 121,'code' => 'LB','name' => "Lebanon",'phonecode' => 961),
            array('id' => 122,'code' => 'LS','name' => "Lesotho",'phonecode' => 266),
            array('id' => 123,'code' => 'LR','name' => "Liberia",'phonecode' => 231),
            array('id' => 124,'code' => 'LY','name' => "Libya",'phonecode' => 218),
            array('id' => 125,'code' => 'LI','name' => "Liechtenstein",'phonecode' => 423),
            array('id' => 126,'code' => 'LT','name' => "Lithuania",'phonecode' => 370),
            array('id' => 127,'code' => 'LU','name' => "Luxembourg",'phonecode' => 352),
            array('id' => 128,'code' => 'MO','name' => "Macau S.A.R.",'phonecode' => 853),
            array('id' => 129,'code' => 'MK','name' => "Macedonia",'phonecode' => 389),
            array('id' => 130,'code' => 'MG','name' => "Madagascar",'phonecode' => 261),
            array('id' => 131,'code' => 'MW','name' => "Malawi",'phonecode' => 265),
            array('id' => 132,'code' => 'MY','name' => "Malaysia",'phonecode' => 60),
            array('id' => 133,'code' => 'MV','name' => "Maldives",'phonecode' => 960),
            array('id' => 134,'code' => 'ML','name' => "Mali",'phonecode' => 223),
            array('id' => 135,'code' => 'MT','name' => "Malta",'phonecode' => 356),
            array('id' => 136,'code' => 'XM','name' => "Man (Isle of)",'phonecode' => 44),
            array('id' => 137,'code' => 'MH','name' => "Marshall Islands",'phonecode' => 692),
            array('id' => 138,'code' => 'MQ','name' => "Martinique",'phonecode' => 596),
            array('id' => 139,'code' => 'MR','name' => "Mauritania",'phonecode' => 222),
            array('id' => 140,'code' => 'MU','name' => "Mauritius",'phonecode' => 230),
            array('id' => 141,'code' => 'YT','name' => "Mayotte",'phonecode' => 269),
            array('id' => 142,'code' => 'MX','name' => "México",'phonecode' => 52),
            array('id' => 143,'code' => 'FM','name' => "Micronesia",'phonecode' => 691),
            array('id' => 144,'code' => 'MD','name' => "Moldova",'phonecode' => 373),
            array('id' => 145,'code' => 'MC','name' => "Monaco",'phonecode' => 377),
            array('id' => 146,'code' => 'MN','name' => "Mongolia",'phonecode' => 976),
            array('id' => 147,'code' => 'MS','name' => "Montserrat",'phonecode' => 1664),
            array('id' => 148,'code' => 'MA','name' => "Morocco",'phonecode' => 212),
            array('id' => 149,'code' => 'MZ','name' => "Mozambique",'phonecode' => 258),
            array('id' => 150,'code' => 'MM','name' => "Myanmar",'phonecode' => 95),
            array('id' => 151,'code' => 'NA','name' => "Namibia",'phonecode' => 264),
            array('id' => 152,'code' => 'NR','name' => "Nauru",'phonecode' => 674),
            array('id' => 153,'code' => 'NP','name' => "Nepal",'phonecode' => 977),
            array('id' => 154,'code' => 'AN','name' => "Netherlands Antilles",'phonecode' => 599),
            array('id' => 155,'code' => 'NL','name' => "Netherlands The",'phonecode' => 31),
            array('id' => 156,'code' => 'NC','name' => "New Caledonia",'phonecode' => 687),
            array('id' => 157,'code' => 'NZ','name' => "New Zealand",'phonecode' => 64),
            array('id' => 158,'code' => 'NI','name' => "Nicaragua",'phonecode' => 505),
            array('id' => 159,'code' => 'NE','name' => "Niger",'phonecode' => 227),
            array('id' => 160,'code' => 'NG','name' => "Nigeria",'phonecode' => 234),
            array('id' => 161,'code' => 'NU','name' => "Niue",'phonecode' => 683),
            array('id' => 162,'code' => 'NF','name' => "Norfolk Island",'phonecode' => 672),
            array('id' => 163,'code' => 'MP','name' => "Northern Mariana Islands",'phonecode' => 1670),
            array('id' => 164,'code' => 'NO','name' => "Norway",'phonecode' => 47),
            array('id' => 165,'code' => 'OM','name' => "Oman",'phonecode' => 968),
            array('id' => 166,'code' => 'PK','name' => "Pakistan",'phonecode' => 92),
            array('id' => 167,'code' => 'PW','name' => "Palau",'phonecode' => 680),
            array('id' => 168,'code' => 'PS','name' => "Palestinian Territory Occupied",'phonecode' => 970),
            array('id' => 169,'code' => 'PA','name' => "Panamá",'phonecode' => 507),
            array('id' => 170,'code' => 'PG','name' => "Papua new Guinea",'phonecode' => 675),
            array('id' => 171,'code' => 'PY','name' => "Paraguay",'phonecode' => 595),
            array('id' => 172,'code' => 'PE','name' => "Perú",'phonecode' => 51),
            array('id' => 173,'code' => 'PH','name' => "Philippines",'phonecode' => 63),
            array('id' => 174,'code' => 'PN','name' => "Pitcairn Island",'phonecode' => 0),
            array('id' => 175,'code' => 'PL','name' => "Poland",'phonecode' => 48),
            array('id' => 176,'code' => 'PT','name' => "Portugal",'phonecode' => 351),
            array('id' => 177,'code' => 'PR','name' => "Puerto Rico",'phonecode' => 1787),
            array('id' => 178,'code' => 'QA','name' => "Qatar",'phonecode' => 974),
            array('id' => 179,'code' => 'RE','name' => "Reunion",'phonecode' => 262),
            array('id' => 180,'code' => 'RO','name' => "Romania",'phonecode' => 40),
            array('id' => 181,'code' => 'RU','name' => "Russia",'phonecode' => 70),
            array('id' => 182,'code' => 'RW','name' => "Rwanda",'phonecode' => 250),
            array('id' => 183,'code' => 'SH','name' => "Saint Helena",'phonecode' => 290),
            array('id' => 184,'code' => 'KN','name' => "Saint Kitts And Nevis",'phonecode' => 1869),
            array('id' => 185,'code' => 'LC','name' => "Saint Lucia",'phonecode' => 1758),
            array('id' => 186,'code' => 'PM','name' => "Saint Pierre and Miquelon",'phonecode' => 508),
            array('id' => 187,'code' => 'VC','name' => "Saint Vincent And The Grenadines",'phonecode' => 1784),
            array('id' => 188,'code' => 'WS','name' => "Samoa",'phonecode' => 684),
            array('id' => 189,'code' => 'SM','name' => "San Marino",'phonecode' => 378),
            array('id' => 190,'code' => 'ST','name' => "Sao Tome and Principe",'phonecode' => 239),
            array('id' => 191,'code' => 'SA','name' => "Saudi Arabia",'phonecode' => 966),
            array('id' => 192,'code' => 'SN','name' => "Senegal",'phonecode' => 221),
            array('id' => 193,'code' => 'RS','name' => "Serbia",'phonecode' => 381),
            array('id' => 194,'code' => 'SC','name' => "Seychelles",'phonecode' => 248),
            array('id' => 195,'code' => 'SL','name' => "Sierra Leone",'phonecode' => 232),
            array('id' => 196,'code' => 'SG','name' => "Singapore",'phonecode' => 65),
            array('id' => 197,'code' => 'SK','name' => "Slovakia",'phonecode' => 421),
            array('id' => 198,'code' => 'SI','name' => "Slovenia",'phonecode' => 386),
            array('id' => 199,'code' => 'XG','name' => "Smaller Territories of the UK",'phonecode' => 44),
            array('id' => 200,'code' => 'SB','name' => "Solomon Islands",'phonecode' => 677),
            array('id' => 201,'code' => 'SO','name' => "Somalia",'phonecode' => 252),
            array('id' => 202,'code' => 'ZA','name' => "South Africa",'phonecode' => 27),
            array('id' => 203,'code' => 'GS','name' => "South Georgia",'phonecode' => 0),
            array('id' => 204,'code' => 'SS','name' => "South Sudan",'phonecode' => 211),
            array('id' => 205,'code' => 'ES','name' => "España",'phonecode' => 34),
            array('id' => 206,'code' => 'LK','name' => "Sri Lanka",'phonecode' => 94),
            array('id' => 207,'code' => 'SD','name' => "Sudan",'phonecode' => 249),
            array('id' => 208,'code' => 'SR','name' => "Suriname",'phonecode' => 597),
            array('id' => 209,'code' => 'SJ','name' => "Svalbard And Jan Mayen Islands",'phonecode' => 47),
            array('id' => 210,'code' => 'SZ','name' => "Swaziland",'phonecode' => 268),
            array('id' => 211,'code' => 'SE','name' => "Sweden",'phonecode' => 46),
            array('id' => 212,'code' => 'CH','name' => "Switzerland",'phonecode' => 41),
            array('id' => 213,'code' => 'SY','name' => "Syria",'phonecode' => 963),
            array('id' => 214,'code' => 'TW','name' => "Taiwan",'phonecode' => 886),
            array('id' => 215,'code' => 'TJ','name' => "Tajikistan",'phonecode' => 992),
            array('id' => 216,'code' => 'TZ','name' => "Tanzania",'phonecode' => 255),
            array('id' => 217,'code' => 'TH','name' => "Thailand",'phonecode' => 66),
            array('id' => 218,'code' => 'TG','name' => "Togo",'phonecode' => 228),
            array('id' => 219,'code' => 'TK','name' => "Tokelau",'phonecode' => 690),
            array('id' => 220,'code' => 'TO','name' => "Tonga",'phonecode' => 676),
            array('id' => 221,'code' => 'TT','name' => "Trinidad And Tobago",'phonecode' => 1868),
            array('id' => 222,'code' => 'TN','name' => "Tunisia",'phonecode' => 216),
            array('id' => 223,'code' => 'TR','name' => "Turkey",'phonecode' => 90),
            array('id' => 224,'code' => 'TM','name' => "Turkmenistan",'phonecode' => 7370),
            array('id' => 225,'code' => 'TC','name' => "Turks And Caicos Islands",'phonecode' => 1649),
            array('id' => 226,'code' => 'TV','name' => "Tuvalu",'phonecode' => 688),
            array('id' => 227,'code' => 'UG','name' => "Uganda",'phonecode' => 256),
            array('id' => 228,'code' => 'UA','name' => "Ukraine",'phonecode' => 380),
            array('id' => 229,'code' => 'AE','name' => "United Arab Emirates",'phonecode' => 971),
            array('id' => 230,'code' => 'GB','name' => "United Kingdom",'phonecode' => 44),
            array('id' => 231,'code' => 'US','name' => "United States",'phonecode' => 1),
            array('id' => 232,'code' => 'UM','name' => "United States Minor Outlying Islands",'phonecode' => 1),
            array('id' => 233,'code' => 'UY','name' => "Uruguay",'phonecode' => 598),
            array('id' => 234,'code' => 'UZ','name' => "Uzbekistan",'phonecode' => 998),
            array('id' => 235,'code' => 'VU','name' => "Vanuatu",'phonecode' => 678),
            array('id' => 236,'code' => 'VA','name' => "Vatican City State (Holy See)",'phonecode' => 39),
            array('id' => 237,'code' => 'VE','name' => "Venezuela",'phonecode' => 58),
            array('id' => 238,'code' => 'VN','name' => "Vietnam",'phonecode' => 84),
            array('id' => 239,'code' => 'VG','name' => "Virgin Islands (British)",'phonecode' => 1284),
            array('id' => 240,'code' => 'VI','name' => "Virgin Islands (US)",'phonecode' => 1340),
            array('id' => 241,'code' => 'WF','name' => "Wallis And Futuna Islands",'phonecode' => 681),
            array('id' => 242,'code' => 'EH','name' => "Western Sahara",'phonecode' => 212),
            array('id' => 243,'code' => 'YE','name' => "Yemen",'phonecode' => 967),
            array('id' => 244,'code' => 'YU','name' => "Yugoslavia",'phonecode' => 38),
            array('id' => 245,'code' => 'ZM','name' => "Zambia",'phonecode' => 260),
            array('id' => 246,'code' => 'ZW','name' => "Zimbabwe",'phonecode' => 263),
        );
        DB::table('countries')->insert($countries);
    }
}
```

```shell
php artisan migrate:fresh --seed
```

## Crear BillingController
```shell
php artisan make:controller BillingController
```

## Método para mostrar formulario método pago
```php
public function paymentMethodForm(): Renderable {
    $countries = Country::all();
    return view('front.billing.payment_method_form', [
        'intent' => auth()->user()->createSetupIntent(),
        'countries' => $countries,
    ]);
}
```

## Actualizar rutas web.php
```php
Route::group(["middleware" => "auth"], function () {
    Route::get("/dashboard", function () {
        return view('dashboard');
    })->name("dashboard");
    
    Route::controller(BillingController::class)
        ->as("billing.")
        ->prefix("billing")
        ->group(function () {
            Route::get("/payment-method", "paymentMethodForm")->name("payment_method_form");
            Route::post("/payment-method", "processPaymentMethod")->name("payment_method");
        });
});
```

## Actualizar layout
```html
@stack("scripts")
</body>
```

## Tarjetas test stripe https://stripe.com/docs/testing

## Formulario pago HTML
```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Actualiza tu método de pago
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap -m-4">
                        <div class="p-4 lg:w-1/2 md:w-full">
                            <div class="relative mb-4">
                                <input placeholder="Titular" type="email" id="card-holder-name" name="card-holder-name"
                                       class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                        </div>
                        <div class="p-4 lg:w-1/2 md:w-full">
                            <div class="relative mb-4">
                                <select class="form-select appearance-none block w-full" id="country" name="country">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <button id="card-button" data-secret="{{ $intent->client_secret }}" class="text-white bg-indigo-500 border-0 py-2 px-6 mt-5 focus:outline-none hover:bg-indigo-600 rounded"
                    >
                        Actualizar método de pago
                    </button>
                </div>

                <form id="payment_method_form" method="post" action="{{ route("billing.payment_method") }}">
                @csrf
                <input type="hidden" id="card_holder_name" name="card_holder_name"/>
                <input type="hidden" id="pm" name="pm"/>
                <input type="hidden" id="country_id" name="country_id"/>
                </form>
            </div>
        </div>
    </div>

    @push("scripts")
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config("cashier.key") }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const country = document.getElementById('country');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
            );

            if (error) {
                alert(error.message)
            } else {
                document.getElementById("pm").value = setupIntent.payment_method;
                document.getElementById("card_holder_name").value = cardHolderName.value;
                document.getElementById("country_id").value = country.value;
                document.getElementById("payment_method_form").submit();
            }
        });
    </script>
    @endpush
</x-app-layout>
```

## Procesar formulario método de pago
```php
/**
 * @throws CustomerAlreadyCreated
 */
public function processPaymentMethod(): RedirectResponse {
    $this->validate(request(), [
        "pm" => "required|string|starts_with:pm_|max:50",
        "card_holder_name" => "required|max:150|string",
        "country_id" => "required|exists:countries,id",
    ]);

    if (!auth()->user()->hasStripeId()) {
        auth()->user()->createAsStripeCustomer([
            "address" => [
                "country" => Country::find(request("country_id"))->code,
            ]
        ]);
    }
    auth()->user()->updateDefaultPaymentMethod(request("pm"));
    return back()
        ->with('notification', ['title' => __("¡Método de pago actualizado!"), 'message' => __("Tu método de pago ha sido actualizado correctamente")]);
}
```

## Dar de alta productos en Stripe
```shell
75,00 € / año
35,00 € cada 3 meses
15,00 € / mes
```

## Crear app/helpers.php 
```php
<?php

/**
 * @param $amount
 * @return int|string
 */
function formatCurrency($amount): int|string {
    if (!$amount) {
        $amount = 0;
    }

    if (!is_numeric($amount)) {
        return $amount;
    }

    return (new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY))->formatCurrency(
        $amount, config("cashier.currency"),
    );
}

function getPlanNameByStripePlan(\Stripe\Plan $plan): string {
    if($plan->interval_count === 3) {
        return "Trimestral";
    } else {
        if ($plan->interval === "year") {
            return "Anual";
        } else {
            return "Mensual";
        }
    }
}
```

## Obtener planes en controlador Billing
```php
/**
 * @throws ApiErrorException
 */
public function plans(): Renderable|RedirectResponse {
    if (!auth()->user()->hasdefaultPaymentMethod()) {
        return back();
    }

    $key = config('cashier.secret');
    $stripe = new StripeClient($key);
    $plans = $stripe->plans->all();
    $plans = $plans->data;
    $plans = array_reverse($plans);

    return view('front.billing.plans', compact("plans"));
}
```

## Crear x-notification
```html
<section class="text-gray-600 body-font overflow-hidden mt-4 mb-0">
    <div class="container mx-auto">
        <div class="w-full">
            <div class="flex rounded-lg h-full bg-gray-800 text-white p-4 flex-col">
                <div class="flex items-center">
                    <div class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full bg-red-500 text-white flex-shrink-0">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg title-font font-medium">{{ session("notification")["title"] }}</h2>
                </div>
                <div class="flex-grow mt-4">
                    <p class="leading-relaxed text-base">{{ session("notification")["message"] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
```

## Utilizar en app.blade.php dentro main
```html
@if(session("notification"))
    <x-notification />
@endif
```

## Actualizar rutas web.php
```php
Route::controller(BillingController::class)
    ->as("billing.")
    ->prefix("billing")
    ->group(function () {
        
        // ...
        
        Route::get("/plans", "plans")->name("plans");
        Route::post("/subscribe", "processSubscription")->name("process_subscription");
    });
```

## Crear vista contratar planes
```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Planes disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 mx-auto">
                <div class="flex flex-wrap -m-4">
                    @foreach($plans as $plan)
                        <div class="p-4 xl:w-1/3 md:w-1/3 w-full">
                            <div class="h-full p-6 rounded-lg border-2 border-red-500 flex flex-col relative overflow-hidden">
                                @if($plan->interval_count === 3)
                                    <span class="bg-red-500 text-white px-3 py-1 tracking-widest text-xs absolute right-0 top-0 rounded-bl">
                                        POPULAR
                                    </span>
                                @endif
                                <h2 class="text-sm tracking-widest title-font mb-1 font-medium">
                                    {{ getPlanNameByStripePlan($plan) }}
                                </h2>
                                <h1 class="text-5xl text-gray-900 leading-none flex items-center pb-4 mb-4 border-b border-gray-200">
                                    <span>{{ formatCurrency($plan->amount / 100) }}</span>
                                </h1>
                                <p class="flex items-center text-gray-600 mb-2">
                                    <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                           stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>
                                    Acceso completo a la plataforma
                                </p>

                                <form method="post" action="{{ route("billing.process_subscription") }}">
                                    @csrf
                                    <input type="hidden" name="price_id" value="{{ $plan->id }}" />
                                    <button type="submit" class="flex items-center mt-auto text-white bg-red-500 border-0 py-2 px-4 w-full focus:outline-none hover:bg-red-600 rounded">
                                        Apuntarme
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                             stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto"
                                             viewBox="0 0 24 24">
                                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
```

## Procesar suscripciones
```php
/**
 * @throws ApiErrorException
 */
public function processSubscription(): RedirectResponse {
    $this->validate(request(), [
        "price_id" => "required|string|starts_with:price_",
    ]);

    $key = config('cashier.secret');
    $stripe = new StripeClient($key);
    $plan = $stripe->plans->retrieve(request("price_id"));

    try {
        auth()
            ->user()
            ->newSubscription('default', request("price_id"))
            ->create(auth()->user()->defaultPaymentMethod()->id);

            return redirect(route("billing.my_subscription"))
                ->with('notification', ['title' => __("¡Gracias por contratar un plan!"), 'message' => __('Te has suscrito al plan ' . getPlanNameByStripePlan($plan) . ' correctamente, recuerda revisar tu correo electrónico por si es necesario confirmar el pago')]);
    } catch (IncompletePayment $exception) {
        return redirect()->route(
            'cashier.payment',
            [$exception->payment->id, 'redirect' => route("billing.my_subscription")]
        );
    } catch (\Exception $exception) {
        return back()->with('notification', ['title' => __("Error"), 'message' => $exception->getMessage()]);
    }
}
```

## Personalizar vista acción requerida
```shell
php artisan vendor:publish --tag="cashier-views"
```

## Helper getSubscriptionNameForUser
```php
function getSubscriptionNameForUser(): string {
    if (auth()->user()->subscribed()) {
        $subscription = auth()->user()->subscription();
        $key = config('cashier.secret');
        $stripe = new StripeClient($key);
        $plan = $stripe->plans->retrieve($subscription->stripe_price);
        return getPlanNameByStripePlan($plan);
    }
    return "N/D";
}
```

## Mi suscripción
```php
public function mySubscription(): Renderable {
    $subscription = getSubscriptionNameForUser();
    return view("front.billing.my_subscription", compact("subscription"));
}
```

```php
Route::controller(BillingController::class)
    ->as("billing.")
    ->prefix("billing")
    ->group(function () {
        // ... 
        
        Route::get("/subscription", "mySubscription")->name("my_subscription");
    });
```

## Actualizar navegación navigation.blade.php
```html
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('billing.payment_method_form')" :active="request()->routeIs('billing.payment_method_form')">
        {{ __('Método de pago') }}
    </x-nav-link>
    <x-nav-link :href="route('billing.plans')" :active="request()->routeIs('billing.plans')">
        {{ __('Planes') }}
    </x-nav-link>
    <x-nav-link :href="route('billing.my_subscription')" :active="request()->routeIs('billing.my_subscription')">
        {{ __('Mi suscripción') }}
    </x-nav-link>
</div>
```

## Panel para ver mi suscripción
```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi suscripción
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-8 divide-y-2 divide-gray-100 bg-gray-400 p-4">
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                        <span class="font-semibold title-font text-white">Plan contratado: {{ $subscription }}</span>
                    </div>
                    <div class="md:flex-grow">
                        <a href="{{ route("billing.portal") }}" class="text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded">Ver mi facturación</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

## Middleware is stripe customer
```shell
php artisan make:middleware EnsureUserIsStripeCustomer
```
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsStripeCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed {
        if ($request->user() && ! $request->user()->hasStripeId()) {
            return redirect(route("dashboard"));
        }

        return $next($request);
    }
}
```
```php
protected $routeMiddleware = [
    // ... 
    
    'is_stripe_customer' => EnsureIsStripeCustomer::class,
];
```

## Habilitar portal stripe https://dashboard.stripe.com/test/settings/billing/portal
```php
/**
 * El portal de Stripe debe ser para usuarios de alta en Stripe
 */
Route::group(["middleware" => "is_stripe_customer"], function () {
    Route::get('/billing/portal', function () {
        return auth()->user()->redirectToBillingPortal(route('dashboard'));
    })->name("billing.portal");
});
```

## Helper isSubscribed
```php
function isSubscribed(): bool {
    return auth()->check() && auth()->user()->subscribed();
}
```

## Middleware IsSubscribed
```shell
php artisan make:middleware EnsureUserIsSubscribed
```
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed {
        if (!isSubscribed()) {
            return redirect(route("dashboard"));
        }

        return $next($request);
    }
}
```
```php
protected $routeMiddleware = [
    // ...
    
    'is_subscribed' => EnsureUserIsSubscribed::class,
];
```

## Directiva Blade subscribed en AppServiceProvider
```php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{
    // ... 
    
    Blade::if("subscribed", function () {
        return isSubscribed();
    });
}
```

## Actualizar dashboard.blade.php
```html
<div class="p-6 bg-white border-b border-gray-200">
    @subscribed
        Estás suscrito
    @else
        No estás suscrito
    @endsubscribed
</div>
```

## ngrok
````shell
ngrok http 8000
````

## Crear webhook Stripe y añadir eventos
```shell
php artisan cashier:webhook --url "{ngrok-url}/stripe/webhook"
```

## Actualizar Middleware VerifyCsrfToken para permitir stripe
```php
protected $except = [
    'stripe/*',
];
```

## Añadir secreto webhook .env
```dotenv
STRIPE_WEBHOOK_SECRET=
```

## Listener Stripe
```shell
php artisan make:listener StripeEventListener
```
```php
<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle the event.
     *
     * @param WebhookReceived $event
     * @return void
     */
    public function handle(WebhookReceived $event) {
        $eventType = $event->payload['type'];

        // TODO comprobar eventos y hacer cosas dependiendo del tipo de evento
    }
}
```

## Actualizar EventServiceProvider
```php
protected $listen = [
    // ...
    
    WebhookReceived::class => [
        StripeEventListener::class,
    ],
];
```

## Configurar correos Stripe
https://dashboard.stripe.com/settings/emails
