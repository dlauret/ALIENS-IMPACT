class Bullet extends Entity{
    constructor({x, y, isAlien}) { // come parametri x e y ---> spawn del bullet
        super({ tag: 'img', className: 'bullet'});
        if(isAlien) {
            this.el.src = '../images/bulletAlien.png';
        }
        else {
            this.el.src = '../images/bullet.png'; 
        }
        
        this.isAlien = isAlien;
        if (navigator.userAgent.indexOf("Chrome") !== -1){
        
            this.SPEED = 7; // velocita'
        } else {
            this.SPEED = 10;
        }
        this.BULLET_IMAGE_WIDTH = 10;
        this.BULLET_IMAGE_HEIGHT = 16;

        this.setX(x);
        this.setY(y);

    }

    update() {
        if(this.isAlien) {
            this.setY(this.y + this.SPEED);

        }
        else {
            this.setY(this.y - this.SPEED);
        }
        
    }

}