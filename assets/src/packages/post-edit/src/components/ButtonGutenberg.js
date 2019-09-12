import React from 'react';

function ButtonGutenberg(props) {
    return (
        <button
            className="editor-block-types-list__item block-editor-block-types-list__item editor-block-list-item-gallery"
            aria-label="Gallery"
            onClick={props.onClick}>
            <span className="editor-block-types-list__item-icon block-editor-block-types-list__item-icon">
                <span className="editor-block-icon block-editor-block-icon has-colors">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 64 64" width="24"><path d="m62 29v32l-18-18-6 6-6-6-18 18v-32zm-20 8a4 4 0 1 0 -4 4 4 4 0 0 0 4-4z" fill="#57a4ff"/><path d="m62 61h-12l-12-12 6-6z" fill="#b2fa09"/><path d="m53 15v14h-39v16h-1a4 4 0 0 1 -4-4v-24a4 4 0 0 1 4-4h38a2.006 2.006 0 0 1 2 2z" fill="#ffc477"/><path d="m51 9v4h-38a4 4 0 0 0 -4 4v24a4 4 0 0 0 4 4h-8a2.006 2.006 0 0 1 -2-2v-38a2.006 2.006 0 0 1 2-2h12a2.006 2.006 0 0 1 2 2 2.015 2.015 0 0 0 2 2h28a2.006 2.006 0 0 1 2 2z" fill="#ff7956"/><path d="m50 61h-36l18-18 6 6z" fill="#9cdd05"/><circle cx="38" cy="37" fill="#ff5023" r="4"/><path d="m14 18h3v-2h-4a1 1 0 0 0 -1 1v4h2z"/><path d="m12 23h2v2h-2z"/><path d="m62 28h-8v-13a3 3 0 0 0 -2-2.816v-3.184a3 3 0 0 0 -3-3h-28a1 1 0 0 1 -1-1 3 3 0 0 0 -3-3h-12a3 3 0 0 0 -3 3v38a3 3 0 0 0 3 3h8v15a1 1 0 0 0 1 1h48a1 1 0 0 0 1-1v-32a1 1 0 0 0 -1-1zm-1 30.586-16.293-16.293a1 1 0 0 0 -1.414 0l-5.293 5.293-5.293-5.293a1 1 0 0 0 -1.414 0l-16.293 16.293v-28.586h46zm-13.414 1.414h-31.172l15.586-15.586zm-8.172-11 4.586-4.586 15.586 15.586h-9.172zm-35.414-6v-38a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1 3 3 0 0 0 3 3h28a1 1 0 0 1 1 1v3h-37a5.006 5.006 0 0 0 -5 5v24a4.948 4.948 0 0 0 1.026 3h-4.026a1 1 0 0 1 -1-1zm6-2v-24a3 3 0 0 1 3-3h38a1 1 0 0 1 1 1v13h-38a1 1 0 0 0 -1 1v15a3 3 0 0 1 -3-3z"/><path d="m38 42a5 5 0 1 0 -5-5 5.006 5.006 0 0 0 5 5zm0-8a3 3 0 1 1 -3 3 3 3 0 0 1 3-3z"/></svg>
                </span>
            </span>
            <span className="editor-block-types-list__item-title">My Slider Gallery</span>
        </button>
    )
}

export default ButtonGutenberg;