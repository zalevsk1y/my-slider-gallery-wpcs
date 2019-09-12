import React from 'react';
import {Input} from '../../components/elements/Input'
import {connect} from 'react-redux';
import {updateMisc} from '../../actions/post-data'
import PropTypes  from 'prop-types';
/**
 * Image Pane. Reorder gallery images.
 */
export class MiscPane extends React.Component{
    constructor(props){
        super(props);
        this.state={...this.props.misc}
        this.changeHandler=this.changeHandler.bind(this);
    }
    changeHandler(state,propName){
        this.props.updateMisc({...this.props.misc,[propName]:state},this.props.selectedShortcode);
    }
    render(){
        const misc=this.props.misc;
        return(
            <div className="misc-pane">
                <h6 className="text-nowrap d-flex ml-2 ">Miscellaneous Settings page</h6>
                <p className="w-auto  ml-2 mr-2 border-bottom pb-3" >You may customize your gallery by using additional settings below.<br></br>Need some help? Read the <a href='admin.php?page=my-gallery-menu-about'>Documentation</a>&nbsp; or Watch a  <a href='admin.php?page=my-gallery-menu-about'>Video</a></p>
                <table className="config-table">
                    <tbody>
                        <tr>
                            <th>Gallery title</th>
                            <td>
                                <Input type="text" propName="title" className="form-control my-gallery-input-title" onBlur={this.changeHandler} value={misc.title}/>
                                <p className="description">Specify titles for your gallery</p>
                            </td>
                        </tr>
                   
                        
                    </tbody>
                </table>

            </div>
        )
    }
}

function mapStateToProps(state){
    const selectedShortcode=state.postData?state.postData.selectedShortcode:false;
    const misc=state.postData&&state.postData.shortcodes[selectedShortcode]?state.postData.shortcodes[selectedShortcode].settings.misc:false;
    return {
        selectedShortcode,
        misc
    }
}
function mapDispatchToProps(dispatch){
    return {
        updateMisc:(newMisc,shortcodeId)=>{
            dispatch(updateMisc(newMisc,shortcodeId))
        }
    }
}
export default connect(mapStateToProps,mapDispatchToProps)(MiscPane);

MiscPane.propTypes={
    selectedShortcode:PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.bool
    ]).isRequired,
    misc:PropTypes.oneOfType([
        PropTypes.object,
        PropTypes.bool
    ]).isRequired,
    updateMisc:PropTypes.func.isRequired
}
