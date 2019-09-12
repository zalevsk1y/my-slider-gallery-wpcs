import React from 'react';
import {Card} from '../elements/Card';
import {Button} from '../elements/Button';
import PropTypes from 'prop-types';
/**
 * Card that allow user create new shortcode gallery or save existent changes. 
 * 
 * @param {function} createNewGallery Callback that creates new gallery shortcode.
 * @param {function} updatePostData Callback sends changes in post shortcodes to the server. 
 */
export function SavePostCard({createNewGallery,updatePostData}){
    return (
        <Card title="Save to Post">
            <p className="card-text">
                    You can add shotrcodes to your post by pressing "Save" button.
                    Also available additional settings that will help customize your gallery. 
                    To delete gallery click the "Delete" button.
                    You can copy the shortcode and paste it anywhere in your post.</p>
            <Button className="btn btn-primary" onClick={updatePostData}>Save</Button>
            <Button className="btn btn-primary ml-2" onClick={createNewGallery}>New Gallery</Button>

        </Card>
    )
} 

SavePostCard.propTypes={
    createNewGallery:PropTypes.func.isRequired,
    updatePostData:PropTypes.func.isRequired
}