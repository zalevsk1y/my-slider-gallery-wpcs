import React from 'react';
import ImageItem from '../../components/elements/ImageIten'
import GallerySortable from '../../components/GallerySortable';
import {connect} from 'react-redux';
import arrayMove from 'array-move';
import {setNewImagesOrder} from '../../actions/post-data';
import PropTypes  from 'prop-types';
/**
 * Image Pane. Reorder gallery images.
 */

export  class ImagesPane extends React.Component{
    constructor(props){
        super(props);        
        this.changeHandler=this.changeHandler.bind(this);   
    }
    changeHandler({oldIndex,newIndex}){
        const newOrder=arrayMove(this.props.images,oldIndex, newIndex)
        this.props.reorderImages(newOrder,this.props.selectedShortcode);
    }
    renderImages(){
        const images=this.props.images;
        if (!images&&!(images.length>0)) return [];
       const imgArr=images.map((item,key)=>{
           return <ImageItem title={(item.title?itemTitle:key)} key={key.toString()} data-id={item.id} src={item.url}/>

       })            
        return imgArr;
    }
    render(){
        const items=this.renderImages()
        return (
            <div className="images-pane">
                <h6 className="text-nowrap d-flex  ml-2 ">Gallery images</h6>
                <p className="w-auto  ml-2 mr-2 border-bottom pb-3 ">Drag to change the order.<br></br>Need some help? Read the <a href='admin.php?page=my-gallery-menu-about'>Documentation</a>&nbsp; or Watch a <a href='admin.php?page=my-gallery-menu-about'>Video</a></p>
                <GallerySortable  items={items} onChange={this.changeHandler}/>
            </div>
        )
    }
}

function mapStateToProps(state){
    const selectedShortcode=(state.postData&&state.postData.selectedShortcode)!=undefined?state.postData.selectedShortcode:false;
    const images=selectedShortcode!==false?state.postData.shortcodes[selectedShortcode].images:false;
    return {
        selectedShortcode,
        images
    }
}
function mapDispatchToProps(dispatch){
    return {
        reorderImages:(newOrder,shortcodeId)=>{
            dispatch(setNewImagesOrder(newOrder,shortcodeId));
        }
    }
}

export default connect(mapStateToProps,mapDispatchToProps)(ImagesPane)

ImagesPane.propTypes={
    selectedShortcode:PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.bool
    ]).isRequired,
    images:PropTypes.oneOfType([
        PropTypes.array,
        PropTypes.bool
    ]).isRequired,
    reorderImages:PropTypes.func.isRequired
}