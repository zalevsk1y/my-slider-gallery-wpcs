import Message from "@my-gallery/message";
import {connect} from "react-redux";

function mapStateToProps(state){
    return {
        message:state.main.message
    }
}

export default connect(mapStateToProps)(Message);