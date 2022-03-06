const ALIEN_ROWS = 4;
const ALIEN_COL = 8;
var gameClock = 0;

const scoreGui = new Score();
const livesGui = new Lives();

const keys = {
    a: false,
    d: false,
    [' ']: false, // indica lo spazio
}

// listeners
document.addEventListener('keydown', (event) => {
    keys[event.key] = true;
});
document.addEventListener('keyup', (event) => {
    keys[event.key] = false;
});


// array di Bullet
const bullets = [];

// array di Alien
const aliens = [];
const aliensMatrix = []; // 2d array of aliens

// ship
const ship = new Ship({
    removeLife: () => livesGui.removeALife(), // passiamo il metodo di livesGui
    removeBullet,
    getOverlappingBullet,
});


// creazione alieni
for(let row = 0; row < ALIEN_ROWS; row++) {
    const aliensCol = [];
    for(let col = 0; col < ALIEN_COL; col++) {
        const alien = new Alien({
            x: col * 63 + window.innerWidth/2, // posizioni iniziali
            y: row * 63 + window.innerWidth/9,
            getOverlappingBullet,
            removeAlien,
            removeBullet,
            addToScore: (amount) => scoreGui.addToScore(amount),
        });
        aliens.push(alien);
        aliensCol.push(alien);
    }
    aliensMatrix.push(aliensCol);
}



// ogni 1 sec alieno random ultima riga spara bullet
var timerAliensFireBullets = setInterval((aliensFireBullet), 1000);

// interval per timer
var timerInterval = setInterval(() => {
    gameClock++
    document.getElementById('clock').innerHTML = time_convert(gameClock);
}, 1000);


// funzione principale setInterval 
var mainInterval = setInterval(() => {

    // salvare variabile score per passarla quando game over
    var score = scoreGui.score;
    // ----------------- GAME OVER ----------------------
    // 1) controllare se alieni si scontrano con la ship --> game over
    if(checkIfAliensUnderShip() === true) {
        removeAll();
        window.location.href = `game_over.php?end=bump&score=${score}&time=${gameClock}`; // per caricare nuova pagina
    }

    // 2) controllare se il numero di vite e' = 0
    if (livesGui.lives === 0) {
        removeAll();
        window.location.href = `game_over.php?end=lives&score=${score}&time=${gameClock}`; // per caricare nuova pagina
    }

    // 3) controllare quando tutti gli alieni sono stati uccisi
    if (aliens.length === 0) {
        removeAll();
        window.location.href = `game_over.php?end=win&score=${score}&time=${gameClock}`; // per caricare nuova pagina
    }

    // check su tasto clickato
    if (keys['d'] && ship.x < window.innerWidth - ship.SHIP_IMAGE_WIDTH /*check se esce da schermo*/) {
        ship.moveRight();
    }
    else if (keys['a'] && ship.x > 0) {
        ship.moveLeft();
    }

    if (keys[' ']) {
        // bullets
        // creazione bullets da parte di ship
        ship.fire({
            createBullet,
        });
    }

    // funzione update per ship
    ship.update();

    // loop per ogni bullet e aggiornare posizione
    bullets.forEach((bullet) => {
        bullet.update();
        // rimozione bullets quando fuori schermo
        if (bullet.y < 0 || bullet.y >= window.innerWidth) {
            // rimuoviamo dal DOM
            bullet.remove();
            // rimuoviamo dall'array bullet
            bullets.splice(bullets.indexOf(bullet), 1); 
        }
    });

    // funzione update per aliens
    if(aliens.length > 0) {
        // loop per aliens e chiamiamo la update della Alien
        aliens.forEach((alien) => {
            alien.update();
        });

        if(aliens.length > 0) {
            // prendiamo l'alieno piu' a sx
            const LeftiestAlien = getLeftiestAlien();
            if (LeftiestAlien.x < 30) {
                // loop aliens
                aliens.forEach((alien) => {
                    alien.setDirectionRight(); // aliens cambiano direzione
                    alien.moveDown(); // aliens si abbassano 
                });
            }
        }

        if(aliens.length > 0) {
            const RightiestAlien = getRightiestAlien();
            if (RightiestAlien.x > window.innerWidth - 60) {
                // loop aliens
                aliens.forEach((alien) => {
                    alien.setDirectionLeft(); // aliens cambiano direzione
                    alien.moveDown(); // aliens si abbassano 
                });
            }
        }

    }
}, 20); // 20ms
