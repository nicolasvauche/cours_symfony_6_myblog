import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        this.element.addEventListener('click', this.close.bind(this));

        setTimeout(this.close, 3000);
    }

    close() {
        console.log('close')
        this.element.remove();
    }
}
