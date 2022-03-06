class Lives extends Entity {
    constructor() {
        super(); // div by default

        this.lives = 3;
        this.refreshText();
        this.setX(window.innerWidth / 2 - 55);
        this.setY(window.innerHeight - 50);

        this.el.id = 'lives';
        
    }

    removeALife() {
        this.lives--;
        this.refreshText();
    }

    // aggiornare il testo
    refreshText() {
        var array_lives = new Array(this.lives);
        this.el.innerText = array_lives.fill(String.fromCodePoint(0x1F497)).join(' '); // array di cuori di lunghezza this.lives
    }
}