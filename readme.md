
Sovellus joka kertoo lähimpien lintutornien sijainnin. (Ja myöhemmin ehkä myös muita kohteita.)

Data tallennettu JSON-muotoon. Lähimmät tornit haetaan näin:
- poimitaan osajoukko lähimpiä torneja käyttäjää ympäröivästä bounding boxista
- lasketaan etäisyys jokaiselle osajoukon tornille


Huomioita
=========

- Raakadatan pitää olla UTF-8 -muodossa, muuten json_encode epäonnistuu
- JSON:issa id:n kannattaa olla ei-numeerinen, muuten järjestys voi muuttua

- Tiiran tornidata on muotoa (saatavissa erillisellä luvalla):

    [0] => stdClass Object
        (
            [paikka_id] => 1103
            [kunta] => Akaa
            [nimi] => Toijala Terisjärvi torni
            [yhdistys] => Pirkanmaan Lintutieteellinen Yhdistys ry
            [e_tm35fim] => 333627.843507321
            [n_tm35fim] => 6787759.25745819
            [e_wgs84] => 23.9047312719029
            [n_wgs84] => 61.1888284223278
        )

    [1] => stdClass Object
        (
            [paikka_id] => 5207983
            [kunta] => Alajärvi
            [nimi] => Lehtimäki, Verijärvi, lintutorni
            [yhdistys] => Suomenselän Lintutieteellinen Yhdistys ry
            [e_tm35fim] => 334415.734429835
            [n_tm35fim] => 6972786.90328758
            [e_wgs84] => 23.7469074813067
            [n_wgs84] => 62.8475390323165
        )



TODO
====


DONE
- Styles
- Intro
- Accuracy / timeout -settings
- Oikea data w/ changed names
- Tietosuojailmoitus
- Logging
- hashaa ip loggerissa
- Poista turhat objectit consolesta
- Näytä koordinaattitiedot consolessa
- Twitter & Facebook
- Google Analytics
- http -> https redirect Shellitissä
- Ristiinlinkitys kotiseudun lintujen kanssa
- Testaa että epätarkan koordinaatin pyöristys toimii tornisovelluksessa
- Edge: hakeeko sivu allspecies.php:ta?
- Uusi väritys
- Tarkista että ei luottamuksellista dataa gitissä

MUST
-

SHOULD
- Yritä ensin saada tarkat koordinaatit, ennen timeoutia yritä uudelleen saada epätarkemmat?
- Järkevä virheilmoitus, jos koordinaatit ulkomailta
- Muuta htaccessissa 302 -> 301 jos kaikki toimii
- Dokumentaatio

NICE
- Self-signed cert Tursolle kehitystä varten
- Kaikki tornit kartalle
- Etäisyys tietä pitkin, auto & kevyt liikenne; https://developers.google.com/maps/documentation/distance-matrix/intro
- Tornin tyyppi
- Ajo-ohje tornin parkkipaikalle; nyt torni ei aina ole saavutettavissa lähimmältä tieltä (esim. Fiskarsinmäki). Vaatisi tätä tietoa alkuperäiseen dataan.

