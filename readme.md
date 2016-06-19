
Sovellus joka kertoo lähimpien lintutornien sijainnin. (Ja myöhemmin ehkä myös muita kohteita.)

Data tallennettu JSON-muotoon. Lähimmät tornit haetaan näin:
- poimitaan osajoukko lähimpiä torneja käyttäjää ympäröivästä bounding boxista
- lasketaan etäisyys jokaiselle osajoukon tornille


Huomioita
=========

- Raakadatan pitää olla UTF-8 -muodossa, muuten json_encode epäonnistuu
- JSON:issa id:n kannattaa olla ei-numeerinen, muuten järjestys voi muuttua

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

SHOULD
- Kaikki tornit kartalle
- Muuta htaccessissa 302 -> 301 jos kaikki toimii
- BL:n logo paremmin
- Dokumentaatio
- (Miten self-signed cert Tursolle?)

NICE
- Etäisyys tietä pitkin, auto & kevyt liikenne; https://developers.google.com/maps/documentation/distance-matrix/intro
- Tornin tyyppi
- Ajo-ohje tornin parkkipaikalle; nyt torni ei aina ole saavutettavissa lähimmältä tieltä (esim. Fiskarsinmäki). Vaatisi tätä tietoa alkuperäiseen dataan.

