
Sovellus joka kertoo lähimpien lintutornien sijainnin. (Ja myöhemmin ehkä myös muita kohteita.)

Tapoja hakea lähimmät tornit
- MongoDB; vaatii ajurin palvelimelle (esim. OVH) ja tietokannan (esim. Mlab, OVH)
	- 2dsphere-indeksi ja near-hakuparametri
- Elastic; vaatii ajurin palvelimelle ja tietokannan
- (TÄMÄ TOTEUTETTU) JSON & PHP; vaatii että etäisyys lasketaan joka kerta jokaiselle pisteelle, tai että pisteiden määrää rajataan aluksi muulla tavoin.

http://geojson.org/
https://docs.mongodb.com/v3.2/reference/operator/query/near/#op._S_near
https://docs.mongodb.com/v3.2/core/2dsphere/

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

TODO
- Edge: hakeeko sivu allspecies.php:ta?
- lisää myös kotiseudun lintuihin
- Tarkista että ei luottamuksellista dataa gitissä
- Muuta htaccessissa 302 -> 301 jos kaikki toimii

AFTER RELEASE
- (Miten self-signed cert Tursolle?)


Ajatuksia
=========

- Etäisyys tietä pitkin, auto & kevyt liikenne; https://developers.google.com/maps/documentation/distance-matrix/intro
- Tornin tyyppi


