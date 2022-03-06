const LEFT = 'left';
const RIGHT = 'right';
const POINTS_PER_KILL = 10;


class Alien extends Entity{
    constructor({x, y, getOverlappingBullet, removeAlien, removeBullet, addToScore}) { // come parametri x e y ---> spawn del bullet
        super({ tag: 'img', className: 'alien'});
        this.el.src = '../images/alien.png'; 

        if (navigator.userAgent.indexOf("Chrome") !== -1) {
            this.SPEED = 6; // velocita'
        } else {
            this.SPEED = 10;
        }
        this.DOWN_DISTANCE = 33 + 16;
        this.ALIEN_IMAGE_WIDTH = 33;
        this.ALIEN_IMAGE_HEIGHT = 33;

        this.direction = LEFT;

        this.getOverlappingBullet = getOverlappingBullet;

        this.removeAlien = removeAlien;
        this.removeBullet = removeBullet;

        this.addToScore = addToScore;

        this.setX(x);
        this.setY(y);

    }
    // gli alieni si muovono a dx e sx
    setDirectionRight() {
        this.direction = RIGHT;
    }

    setDirectionLeft() {
        this.direction = LEFT;
    }

    moveDown() {
        this.setY(this.y + this.DOWN_DISTANCE);
    }

    update() { // update position
        if (this.direction === LEFT) {
            this.setX(this.x - this.SPEED);
        }
        else { // RIGHT
            this.setX(this.x + this.SPEED);
        }

        // se un bullet mi colpisce, delete bullet & delete myself
        const bullet = this.getOverlappingBullet(this); // restituisce il bullet se si e' overlapped all'alien corrente
        if (bullet && !bullet.isAlien) { // se bullet non di un alieno allora kill   
            this.el.src = '../images/explosion.png';
            this.removeBullet(bullet);
            this.addToScore(POINTS_PER_KILL);
            this.removeAlien(this);
        }

    }

    

}