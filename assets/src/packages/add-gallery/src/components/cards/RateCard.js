import React from 'react';
import {Card} from '../elements/Card';

export default function RateCard(){
    return (
        <Card title="Rate My Slider Gallery">     
            <h6 className="mt-3">
                Please rate plugin on  <a href="https://wordpress.org/plugins/mygallery/#reviews">Wordpress.org</a>
            </h6>
            <p className="card-text mb-0">Support me and appreciate my efforts to create a quality product. Thanks for your feedback.</p>
            <div className="d-flex justify-content-left">  
                <a href="https://wordpress.org/plugins/mygallery/#reviews">
                    <div className="rating"><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></div>
                </a>
            </div>       
        </Card>
    )
} 