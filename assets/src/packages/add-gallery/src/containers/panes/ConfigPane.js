import React from 'react';
import {Switch} from '../../components/elements/Switch';
import {Select} from '../../components/elements/Select';
import {connect} from 'react-redux';
import {updateConfig} from '../../actions/post-data'
import PropTypes  from 'prop-types';
/**
 * Gallery config pane.
 */
export class ConfigPane extends React.Component{
    constructor(props){
        super(props)
        this.changeHandler=this.changeHandler.bind(this);
    
    }
    changeHandler(state,propName){

        this.props.updateConfig({...this.props.config,[propName]:state},this.props.selectedShortcode);
    }
    getOptionForSelect(length){
        const arr=[];
        for(var i=1,end=length;i<end;i++){
       
            arr.push({id:i,title:i.toString()});
        }
        return arr;
    }
    render(){
        const config=this.props.config;
        return (
            <div className="config-pane">
                <h6 className="text-nowrap d-flex ml-2 ">Gallery Config page</h6>
                <p className="w-auto  ml-2 mr-2 border-bottom pb-3" >You may customize your gallery by using settings below.<br></br>Need some help? Read the <a href='admin.php?page=my-gallery-menu-about'>Documentation</a>&nbsp; or Watch a <a href='admin.php?page=my-gallery-menu-about'>Video</a></p>
                <table className="config-table">
                    <tbody>
                        <tr>
                            <th>Gallery mode</th>
                            <td>
                                <Switch propName="galleryMode" onChange={this.changeHandler} state={config.galleryMode}/>
                                <p className="description">Determines the presence of preview images under the main image.</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Loop</th>
                            <td>
                                <Switch propName="loop" onChange={this.changeHandler} state={config.loop}/>
                                <p className="description">Enables or disables loop for scrolling images.</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Number of thumb items</th>
                            <td>
                                <Select className="my-gallery-narrow-select" propName="thumbsNumber" onChange={this.changeHandler} options={this.getOptionForSelect(10)} selected={config.thumbsNumber}/>
                                <p className="description">Set number of thumbnails under the main image</p>
                            </td>
                        </tr>
                     
                        <tr>
                            <th>Items</th>
                            <td>
                            <Select className="my-gallery-narrow-select" propName="items" onChange={this.changeHandler} options={this.getOptionForSelect(5)} selected={config.mainNumber}/>
                                <p className="description">Determines the number of images in the main gallery window.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        )
    }
}

function mapStateToProps (state){
    const selectedShortcode=(state.postData&&state.postData.selectedShortcode)!=undefined?state.postData.selectedShortcode:false;
    const config=selectedShortcode!==false?state.postData.shortcodes[selectedShortcode].settings.config:false;
    return {
        selectedShortcode,
        config
    }
}
function mapDispatchToProps(dispatch){
    return {
        updateConfig:(config,shortcodeId)=>{
            dispatch(updateConfig(config,shortcodeId))
        }
    }
}

export default connect(mapStateToProps,mapDispatchToProps)(ConfigPane)

ConfigPane.propTypes={
    selectedShortcode:PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.bool
    ]).isRequired,
    config:PropTypes.oneOfType([
        PropTypes.object,
        PropTypes.bool
    ]).isRequired,
    updateConfig:PropTypes.func.isRequired
}