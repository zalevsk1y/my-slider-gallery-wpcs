const path = require("path");
const bodyParser=require('body-parser');

module.exports=(app,server)=>{


app.use(bodyParser.urlencoded({ extended: false }))
app.get('/admin.php',(req,res)=>{
    console.log()
    switch(req.query.page.trim()){
        case('my-gallery-add-gallery'):
            res.sendFile(path.join(__dirname,"assert/index.development.add-gallery.html"))
            break;
        
    }
    
})

app.post('/admin-ajax.php',(req,res)=>{
    var response={};
    //check nonce 

    //check action
    switch (req.query.action.trim()){
        case ('my_gallery_posts_api'):    
            res.sendFile(path.resolve(__dirname,'mock/posts.json'));
            break;
        case ('my_gallery_post_data_api'):
            res.sendFile(path.resolve(__dirname,'mock/postData.json'));
            break;
        case ('my_gallery_shortcode_api'):
            req.query.status=="delete"&&res.sendFile(path.resolve(__dirname,'mock/deleteAccept.json'));
            req.query.status=="save"&&res.sendFile(path.resolve(__dirname,'mock/saveAccept.json'));
            console.log(req.body);
            break;
        
    }
        
})

}