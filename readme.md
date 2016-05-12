
Sovellus joka kertoo lähimpien lintutornien sijainnin. (Ja myöhemmin ehkä myös muita kohteita.)

Tapoja hakea lähimmät tornit
- MongoDB; vaatii ajurin palvelimelle (esim. OVH) ja tietokannan (esim. Mlab, OVH)
	- 2dsphere-indeksi ja near-hakuparametri
- Elastic; vaatii ajurin palvelimelle ja tietokannan
- JSON & PHP; vaatii että etäisyys lasketaan joka kerta jokaiselle pisteelle, tai että pisteiden määrää rajataan aluksi muulla tavoin.

http://geojson.org/
https://docs.mongodb.com/v3.2/reference/operator/query/near/#op._S_near
https://docs.mongodb.com/v3.2/core/2dsphere/

Huomioita
=========

Raakadatan pitää olla UTF-8 -muodossa, muuten json_encode epäonnistuu
