import "elements/turbo-echo-stream-tag";
import "libs";

import * as Turbo from "@hotwired/turbo";

Turbo.StreamActions.redirect = function () {
    const url = this.getAttribute("target");
    if (url) {
        Turbo.visit(url);
    }
};
