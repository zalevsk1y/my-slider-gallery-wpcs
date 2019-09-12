import React from 'react';
import {Card} from '../components/elements/Card';
import {Button} from '../components/elements/Button';
import {Code} from '../components/elements/Code';
import { connect } from 'react-redux';
import config from '@my-gallery/config';
import {selectShortcode,unselectShortcode,stopEditingShortcode,deleteShortcode,deleteUnsavedShortcode} from '../actions/post-data'
import PropTypes  from 'prop-types';
/**
 * Card for shortcode representation.
 */
export class ShortCodeCard extends React.Component{
    constructor(props){
        super(props);
        this.renderButtons=this.renderButtons.bind(this);
        this.selectShortcode=this.selectShortcode.bind(this);
        this.unselectShortcode=this.unselectShortcode.bind(this);
        this.stopEditingShortcode=this.stopEditingShortcode.bind(this);
        this.deleteShortcode=this.deleteShortcode.bind(this);
       
    }
    selectShortcode(){
        this.props.selectShortcode(this.props.id);
    }
    unselectShortcode(){
        this.props.unselectShortcode(this.props.id);
        switch(this.props.status){
            case "draft":
                this.props.deleteUnsavedShortcode(this.props.id);
                break;
            case "changed":
            case "saved":
                this.props.unselectShortcode(this.props.id);
                break;
        }
    }
    stopEditingShortcode(){
        this.props.stopEditingShortcode(this.props.id,this.props.shortcode)
    }
    deleteShortcode(){
        if(this.props.isSelected)this.props.unselectShortcode(this.props.id)
        switch(this.props.status){
            case "draft":
                this.props.deleteUnsavedShortcode(this.props.id);
                break;
            case "changed":
            case "saved":
                this.props.deleteShortcode(this.props.id)
                break;
        }
        
    }
    renderButtons(){
        if(this.props.isSelected){
            return (
                <div>
                    <Button className="btn btn-primary" onClick={this.stopEditingShortcode}>Ok</Button>
                    <Button className="btn btn-primary ml-2" onClick={this.unselectShortcode}>Cancel</Button>
                </div>
            )
        }
        return (
            <div>
                <Button className="btn btn-primary" onClick={this.selectShortcode}>Edit</Button>
                <Button className="btn btn-primary ml-2" onClick={this.deleteShortcode}>Delete</Button>
            </div>
        )
    }
    createShortcode(){
        return '['+config.galleryName+' '+this.props.code.ids+' '+this.props.code.misc+' '+this.props.code.config+']'
    }
    render(){
        const id=this.props.id,
              className=this.props.className?this.props.className:"";
        return (
            <Card title={"Gallery #"+(id+1)} className={className} id={"my-gallery-card-"+id}>
                <Code>{this.createShortcode()}</Code>
                <this.renderButtons />
            </Card>
        )
    } 
}

function mapStateToProps (state,props){
    
    const selectedShortcode=state.postData.selectedShortcode,
          isSelected=(!(selectedShortcode===false)&&selectedShortcode==props.id),
          status=state.postData.shortcodes[props.id].status,
          shortcode=state.postData.shortcodes[props.id];
    return {
        isSelected,
        postId:state.postData.id,
        status,
        shortcode
        
    }
}
function mapDispatchToProps(dispatch){
    return {
        selectShortcode:(shortcodeId)=>{
            dispatch(selectShortcode(shortcodeId))
        },
        unselectShortcode:(shortcodeId)=>{
            dispatch(unselectShortcode(shortcodeId))
        },
        stopEditingShortcode:(shortcodeId,shortcode)=>{
            dispatch(stopEditingShortcode(shortcodeId,shortcode))
        },
        deleteShortcode:(shortcodeId)=>{
            dispatch(deleteShortcode(shortcodeId))
        },
        deleteUnsavedShortcode:(shortcodeId)=>{
            dispatch(deleteUnsavedShortcode(shortcodeId))
        }
    }
}


export default connect(mapStateToProps,mapDispatchToProps)(ShortCodeCard);

ShortCodeCard.propTypes={
    id:PropTypes.number.isRequired,
    isSelected:PropTypes.bool.isRequired,
    postId:PropTypes.string.isRequired,
    status:PropTypes.oneOf([
        "draft",
        "changed",
        "saved"
    ]),
    shortcode:PropTypes.object.isRequired,
    selectShortcode:PropTypes.func.isRequired,
    unselectShortcode:PropTypes.func.isRequired,
    stopEditingShortcode:PropTypes.func.isRequired,
    deleteShortcode:PropTypes.func.isRequired,
    deleteUnsavedShortcode:PropTypes.func.isRequired
}