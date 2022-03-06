class Score extends Entity {
    constructor() {
        super({tag: 'div', className: 'score'}); // div by default

        this.score = 0;
        this.refreshText();
        this.setX(window.innerWidth / 2);

        this.el.className += ' gameData'; // per avere la stessa classe con clock la aggiungiamo
        
    }

    addToScore(amount) {
        this.score += amount;
        this.refreshText();
    }

    // aggiornare il testo
    refreshText() {
        this.el.innerText = `Score: ${this.score}`;
    }

}