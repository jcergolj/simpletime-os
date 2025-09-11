import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu", "openIcon", "closeIcon"]

    toggle() {
        const isCurrentlyHidden = this.menuTarget.classList.contains('hidden')

        if (isCurrentlyHidden) {
            this.menuTarget.classList.remove('hidden')
            this.openIconTarget.classList.add('hidden')
            this.closeIconTarget.classList.remove('hidden')
            this.element.setAttribute('aria-expanded', 'true')
        } else {
            this.menuTarget.classList.add('hidden')
            this.openIconTarget.classList.remove('hidden')
            this.closeIconTarget.classList.add('hidden')
            this.element.setAttribute('aria-expanded', 'false')
        }
    }

    close() {
        if (!this.menuTarget.classList.contains('hidden')) {
            this.toggle()
        }
    }
}