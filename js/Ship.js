class Ship extends Entity {
    constructor({removeLife, removeBullet, getOverlappingBullet }) {
        super({tag: 'img', className: 'ship'}); // costruttore Entity
        this.el.src = '../images/ship.png';

        if (navigator.userAgent.indexOf("Chrome") !== -1){
        
            this.SPEED = 8; // velocita'
        } else {
            this.SPEED = 12;
        }
        this.SHIP_IMAGE_WIDTH = 50;
        this.canFire = true;

        this.hasGotShot = false; // var per tenere traccia se sei stato colpito

        this.removeLife = removeLife;
        this.getOverlappingBullet = getOverlappingBullet;
        this.removeBullet = removeBullet;

        this.timeOut;

        this.spawn();

    }

    moveRight() {
        if(this.hasGotShot) return; // se sei stato colpito non ti muovi
        this.setX(this.x + this.SPEED); // modifichiamo posizione con speed
    }

    moveLeft() {
        if(this.hasGotShot) return; // se sei stato colpito non ti muovi
        this.setX(this.x - this.SPEED);
    }

    fire({ createBullet }) {
        if(this.canFire) {
            this.canFire = false;
            createBullet({
                x: this.x + this.SHIP_IMAGE_WIDTH / 2 - 3, // al centro della ship
                y: this.y,
            });
            // tempo da attendere per sparare di nuovo
            this.timeOut = setTimeout(() => {
                this.canFire = true;
            }, 500);
        }

    }

    spawn() {
        this.setX(window.innerWidth / 2 - 25);
        this.setY(window.innerHeight - 90);
    }

    kill() {
        this.hasGotShot = true;
        this.canFire = false; // non facciamo sparare
        clearTimeout(this.timeOut); // per non far sparare quando e' attivo il timeout sopra (dato che mette a true canFire)
        setTimeout(() => {
            this.hasGotShot = false;
            this.canFire = true;
            this.el.style.opacity = 1; // modifichiamo style ship
            
            this.spawn(); // settiamo posizioni iniziali
        }, 2000);

        this.el.style.opacity = 0; // modifichiamo style ship
    }


    update() {
        // se un bullet mi colpisce, delete bullet & delete myself
        const bullet = this.getOverlappingBullet(this); // restituisce il bullet se si e' overlapped all'alien corrente
        if (bullet && bullet.isAlien && !this.hasGotShot) { // se bullet non di un alieno allora kill & se non e' stato colpito (!hasGotShot)

            // kill ship e update
            this.removeBullet(bullet);
            this.removeLife();

            this.kill();
        }
    }

}