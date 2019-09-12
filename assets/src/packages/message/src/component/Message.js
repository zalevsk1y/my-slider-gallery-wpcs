import React from 'react';

 export class Message extends React.Component{
    constructor(props){
        super(props);
        this.state={open:!(!props.message)};
        this.close=this.close.bind(this);
       
    }
    close(){
        this.setState({open:false})
    }
    
    componentDidUpdate(prevProps){
        if(this.props!==prevProps){
            if(this.state.open){
                this.close();
                window.setTimeout(()=>{
                    this.setState({open:true})
                },200)
            }else{
                this.setState({open:true})
            }
        }

    }
  
    render(){
        const text=this.props.message?this.props.message.text:'',
              open=this.state.open
        return (
            <div id="notice" className={"d-flex justify-content-between notice notice-warning "+(open?"open":"closed")}>
                <p>{text}</p>
                <span id="close-message" className="fo" onClick={this.close}></span>
            </div>
        )
    }
} 