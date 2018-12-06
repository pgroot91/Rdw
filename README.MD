Overview
========

This component provides classes to retrieve data from the RDW

Installation
============

Add the component to your `composer.json` file:

```javascript
require: {
    // ...
    "amooij/rdw": "3.*"
    // ...
}
```

Then run a composer update:

```shell
composer.phar update
# OR
composer.phar update amooij/rdw # to only update the component
```

Usage
=====

## Service

### howto
```
    $kentekenRepository = new Nettob\Component\Rdw\Repository\KentekenRepository();
    $assenRepository = new Nettob\Component\Rdw\Repository\AssenRepository();
    $brandstofRepository = new Nettob\Component\Rdw\Repository\BrandstofRepository();
    $carosserieRepository = new Nettob\Component\Rdw\Repository\CarrosserieRepository();
    $carosserieSpecifiekRepository = new Nettob\Component\Rdw\Repository\CarrosserieSpecifiekRepository();
    $voertuigklasseRepository = new Nettob\Component\Rdw\Repository\VoertuigklasseRepository();


    $kentekenNummer = '';

    $kenteken = $kentekenRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($kenteken);
    echo '</pre>';

    $assen = $assenRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($assen);
    echo '</pre>';

    $brandstof = $brandstofRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($brandstof);
    echo '</pre>';

    $carosserie = $carosserieRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($carosserie);
    echo '</pre>';

    $carosserieSpecifiek = $carosserieSpecifiekRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($carosserieSpecifiek);
    echo '</pre>';

    $voertuigklasse = $voertuigklasseRepository->findOneBy('kenteken', $kentekenNummer);
    echo '<pre>';
    var_dump($voertuigklasse);
    echo '</pre>';
    ```
## Api

The data set is avalible on the opendata.rdw.nl, named `Open Data RDW: Gekentekende_voertuigen`.
