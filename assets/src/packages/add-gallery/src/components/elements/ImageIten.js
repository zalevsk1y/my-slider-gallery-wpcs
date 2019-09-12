import React from 'react';
import config from "@my-gallery/config";
import PropTypes from 'prop-types';
/**
 * Image element with lazy load.
 * 
 * @param {string} src Source url of the image. 
 */

export default class ImageItem extends React.Component{
    /**
     * Init function.
     * 
     * @param {object} props 
     */
    constructor(props){
        super(props);
        this.state={src:config.defaultImage}
        this.lazyLoad.call(this);
    }
    /**
     * Lazy load for image. 
     */
    lazyLoad(){
        const img=new Image();
        img.src=this.props.src;
        img.onload=function(){
            this.setState({src:this.props.src});
        }.bind(this);
    }
    render(){
        return(
            <div className="image-card-body">
                <img src={this.props.src} alt="" />
                <div className="text-center border bg-light">
                    <span>{"image"+this.props.title}</span>
                </div>
            </div>
        )
    }
} 

ImageItem.propTypes={
    src:PropTypes.string
}