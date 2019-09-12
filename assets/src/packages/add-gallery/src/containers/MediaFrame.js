import React from 'react';
import  MediaFrameBase from '@my-gallery/media-frame';
import Button from '../components/elements/Button';
import {wp} from 'globals';
import {connect} from 'react-redux';
import {updateShortcodeImages,createNewShortcode} from '../actions/post-data';
import PropTypes  from 'prop-types';
/**
 * Modal frame to select,remove,reorder or download images.
 */

export class MediaFrame extends MediaFrameBase{
    constructor(props){
        super(props);
        this.getSelected=this.getSelected.bind(this);
        this.onClick=this.onClick.bind(this);
        //add Backbone listener to add selected images. 
        //If call getSelected() directly collection of image models will be empty
        //so you ll need to get then manual wp.media.query
        //Example: https://github.com/WordPress/gutenberg/blob/b710cc5619e3ba22bc2c81c1fc39aa1e207a9ad7/packages/media-utils/src/components/media-upload/index.js
        //getAttachmentsCollection function
        this.frame.on('open',this.getSelected.bind(this))
    }
    getSelected(){
        const shortcodeId=this.props.selectedShortcode;
        if(shortcodeId!==false&&this.props.shortcodes[shortcodeId].images.length>0){
            const selection = this.frame.state('gallery').get( 'selection' ),
                shortcodeId=this.props.selectedShortcode,
                attachment=this.props.shortcodes[shortcodeId].images.map(elem => {
                    return wp.media.attachment( parseInt(elem.id) );
                });
            // attachment should be an array if you want select single image use [attachment]
            selection.add( attachment  );
        }
    }
    
    onUpdate(selection){
        const attachment = this.getNewImages(selection.models);
        attachment&&this.props.updateShortcodeImages(attachment,this.props.selectedShortcode)
    }

    getNewImages(models){
        let needToUpdate=false;
        const oldImages=this.props.shortcodes[this.props.selectedShortcode].images;
        const newImages=models.map((item,key)=>{
            if (!needToUpdate&&!(oldImages[key]&&oldImages[key].id==item.id)) needToUpdate=true;
            return {
                id:item.id,
                url:item.attributes.sizes.thumbnail.url
                    }
        }) 
        return needToUpdate?newImages:false;
    }
    onClick(){
        const shortcodeId=this.props.selectedShortcode;
        if(shortcodeId===false){
            this.props.createNewGallery(this.props.postId);
        }
        this.frame.open();
    }
    componentDidUpdate(prevProps){
        if(prevProps.postId!==this.props.postId)        
          {
    //settings post id for media-frame global variable so that attached to this post images could be selected
          wp.media.model.settings.post.id=Number(this.props.postId);
          }
    }
    render(){
        
        return(
            <Button className="btn btn-primary"c onClick = {this.onClick}>Select image</Button>
        )
    }
}

function mapStateToProps(state){
    const shortcodes=state.postData?state.postData.shortcodes:[],
          postId=state.postData?state.postData.id:false,
          selectedShortcode=state.postData?state.postData.selectedShortcode:false;
    return {
        shortcodes,
        selectedShortcode,
        //need for parent class. 
        postId
    }
}
function mapDispatchToProps(dispatch){
    return {
        updateShortcodeImages:(images,shortcodeId)=>{
            dispatch(updateShortcodeImages(images,shortcodeId));
        },
        createNewGallery:(postId)=>{
            dispatch(createNewShortcode(postId));
        },
    }
}

export default connect(mapStateToProps,mapDispatchToProps)(MediaFrame);

MediaFrame.propTypes={
    shortcodes:PropTypes.array.isRequired,
    selectedShortcode:PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.bool
    ]).isRequired,
    postId:PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.bool
    ]).isRequired,
    updateShortcodeImages:PropTypes.func.isRequired,
    createNewGallery:PropTypes.func.isRequired
}
