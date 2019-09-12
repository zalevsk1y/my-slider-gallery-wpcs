import React from "react";
import ReactDOM from "react-dom";
import MediaFrame from "@my-gallery/media-frame";
import ButtonGutenberg from "./components/ButtonGutenberg";
import ButtonClassic from "./components/ButtonClassic";
import {shortcode} from '@my-gallery/helpers';
/**
 * Renders and insert React component in gutenberg editor tools container,
 * insert in menu list after menu will be rendered.
 *
 */
export function myGalleryGutenberg() {
    const liElement = document.createElement("li");
    liElement.className = "editor-block-types-list__list-item block-editor-block-types-list__list-item";
    ReactDOM.render(
        <MediaFrame button={ButtonGutenberg} onUpdate={shortcode}/>, liElement);
    const menuButton = document.querySelector(".editor-inserter");
    menuButton.addEventListener("click", () => {
        window.setTimeout(() => {
            const el = document.querySelector(".editor-block-types-list");
            el && el.prepend(liElement);
        }, 10);
    });
}

/**
 * Renders and insert React component in classic editor tools container.
 *
 */
export function myGalleryClassic() {
    const buttonContainer = document.querySelector("#my-gallery-media-button");
    ReactDOM.render(
        <MediaFrame button={ButtonClassic} onUpdate={shortcode}/>, buttonContainer);
}
