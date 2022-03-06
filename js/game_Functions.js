// funzione per formato clock
const time_convert = (num) => {
  var minutes = Math.floor(num / 60);  
  var seconds = num % 60;
  if(seconds < 10){
      seconds = "0"+seconds;
  }
  return minutes + ":" + seconds;         
};


// metodo per controllare overlapping tra due elemnti
const isOverlapping = (entity1, entity2) => {
    const rect1 = entity1.el.getBoundingClientRect(); // funzioni per trasformarle in rectangle
    const rect2 = entity2.el.getBoundingClientRect();
    return !(
        rect1.right < rect2.left ||
        rect1.left > rect2.right ||
        rect1.bottom < rect2.top ||
        rect1.top > rect2.bottom
    );

};

// metodo che prende entity e dice se overlapping con qualche bullets (e restituisce il bullet)
const getOverlappingBullet = (entity) => {
    for(let bullet of bullets) {
        if (isOverlapping(entity, bullet)) {
            return bullet;
        }
    }
    return null;
};

// metodo per rimuovere da array aliens alien eliminato
const removeAlien = (alien) => {
    // dato che quando faccio game over gli passo un numero (l'indice dell'alien)
    // allora devo salvarmi l'oggetto alien che poi devo eliminare e quindi lo prendo dall'array aliens (se passiamo un intero)
    // se passimao l'oggetto non c'è bisogno (uguaglianza)
    
    if(typeof alien === "number"){
        var thisAlien = aliens[alien];
    } else {
        var thisAlien = alien;
    }

    if(aliens[alien] !== null) {
            
        aliens.splice(aliens.indexOf(alien), 1); // remove 1 in that position
    
        // rimuovere anche da aliensMatrix
        for(let row = 0; row < ALIEN_ROWS; row++) {
            for(let col = 0; col < ALIEN_COL; col++) {
                if (aliensMatrix[row][col] === alien) {
                    aliensMatrix[row][col] = null;
                }
            }
        }
    }
    // faccio cosi' per far restare l'immagine dell'esplosione sullo schermo quando si spara ad un alien
    // nel caso di gameover niente esplosione
    if(typeof alien === "number") {
        thisAlien.remove();
    }
    else {
        if(aliens.length === 0) {
            // se l'ultimo non aspettare
            alien.remove();
        }
        else {
            setTimeout(function() {
                alien.remove();
            }, 100);
        }

    }
    
};

// parametro isAlien per far capire chi lo spara
const createBullet = ({x, y, isAlien = false}) =>{
    bullets.push(
        new Bullet({ // passiamo x e y ship ---> spawn bullet
        x,
        y,
        isAlien,
    }));
};

// metodo per rimuovere da array bullets il bullet eliminato
// anche qui come nel caso alieni utilizzo il caso number poiche'
// passiamo un intero alla funzione
const removeBullet = (bullet) => {

    if(typeof bullet === "number"){
        var thisBullet = bullets[bullet];
    } else {
        var thisBullet = bullet;
    }

    if(bullets[bullet] !== null) {
        
        bullets.splice(bullets.indexOf(bullet), 1);
        thisBullet.remove();
        
    }
};

// 2d loop per ogni colonna e vede ogni riga
// restituisce array con gli alieni piu' in basso 
// (non solo ultima riga, ma anche di righe superiori, ma piu' in basso)
const getBottomAliens = () => {
    const bottomAliens = []; // array dove ci saranno gli aliens piu' in giu'
    for(let col = 0; col < ALIEN_COL; col++) {
        for(let row = ALIEN_ROWS - 1; row >= 0; row--) {
            if(aliensMatrix[row][col]) {
                bottomAliens.push(aliensMatrix[row][col]);
                break; // go next column
            }
        }
    }
    return bottomAliens;
};


// controllo se posizione degli alieni e' in linea con quella della ship
const checkIfAliensUnderShip = () => {
    var bottomAliens = getBottomAliens();
    var under = false;
    bottomAliens.forEach((al) => {
        // se l'alieno va piu' in basso della ship
        if(al.y+25 >= ship.y) {
            under = true;
        }
    });
    return under;
}


// metodo per avere random un alien dalla lista aliensList passata
const getRandomAlien = (aliensList) => {
    return aliensList[
        parseInt(Math.random() * aliensList.length)
    ];
};


// metodo per far sparare bullet agli alieni
const aliensFireBullet = () => {
    const randomAlien = getRandomAlien(aliens);
    // spara bullet da random alien
    createBullet({
        x: randomAlien.x + 15,
        y: randomAlien.y + 33,
        isAlien: true,
    });
}


// funzione per sapere quando alieni piu' a sinistra colpiscono il bordo
const getLeftiestAlien = () => {
    return aliens.reduce((minimumAlien, currentAlien) => { // per ogni alieno (reduce method)
        return currentAlien.x < minimumAlien.x ? currentAlien : minimumAlien;
    });
};

// funzione per sapere quando alieni piu' a destra colpiscono il bordo
const getRightiestAlien = () => {
    return aliens.reduce((maximumAlien, currentAlien) => {
        return currentAlien.x > maximumAlien.x ? currentAlien : maximumAlien;
    });
};

// funzione per eliminare elementi DOM
const removeAll = () => {
    // disattiviamo gli interval attivi
    clearInterval(mainInterval);
    clearInterval(timerAliensFireBullets);
    clearInterval(timerInterval);

    // eliminare tutti gli alien tramite funzione remove() di Entity
    // eliminare nave per stesso motivo
    // eliminare tutti i bullet
    if(aliens.length > 0){
        for(i = aliens.length-1; i >= 0 ; i--) {
            removeAlien(i);
        }
    }

    if(bullets.length > 0) {
        for(i = bullets.length-1; i >= 0; i--) {
            removeBullet(i);
        }
    }

    // remove ship
    ship.remove();
};