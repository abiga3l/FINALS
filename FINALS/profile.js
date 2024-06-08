
function loadProfile(){
    fetch('/getProfile',{
        method:'GER',
        header:{
            'Authorization': 'Bearer' + localStorage.getItem('token'),
        }
    })
    .then(response =>response.json())
    .then(data =>{
        if (data.name &&data.email){
            document.getElementById('displayNme'),textContent =data.name;
            document.getElementById('displayEmail'),textContent =data.email;
            document.getElementById('name').value=data.name;
            document.getElementById('email').value=data.email;
        }else{
            document.getElementById('displayName').textContent = 'No Name Set';
            document.getElementById('displayEmail').textContent ='No Email Ser';
        }
    });
}
document.getElementById('profileForm').addEventListener('submit',function(e){
    e.preventDefault();
    const name=
    document.getElementById('name').value;
    const email=
    document.getElentById('email').value;
    fetch('/updateProfile',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization':'Bearer' + localStorage.getItem('token'),
        },
        body:
        JSON,stringify({name,email})
    })
    .then(response =>response.json())
    .then(data =>{
        document.getElementById('displayName').textContent=data.name;
        document.getElementById('displayEmail').textContent=data.email
    });
});
window.onload=loadProfile;

const express = require('express');
const bodyParser = require ('body-parser');
const mongoose = require('mongoose');
const jwt = require('jsonwebtoken');
const app = express();
app.use(bodyParser.json());
mongoose.connect('mongodb://localhost:27017/harmonyHub',{useNewUrlParser:true,useUnifiedTopology:true});
const userSchema = new mongoose.Schema({
    name:String,
    email:{type:String,uniques:true},
    password:String
});
const User = mongoose.model('User',userSchema);
const authMiddleware =(req,res,next) =>{
    const token = req.headsers['authorization'];
    if(token){
        jwt.verify(token,'secretKey',(err,decoded) => {
            if (err) {
                return res.json({ success:false ,message: 'Failed to authenticate token.'});
            }else{
                req.userId =decoded.userId;next();
            }
        });
    }else{
        return res.status(403).send({success:false, message:'No token provided.'});
    }
};
app.get('/getProfile',authMiddleware,async(req,res =>{
    const user= await User.findById(req.userId);res.json({name:user.name,email:user.email})
});
app.post('updateProfile',authMiddleware,async(req, res=>{
    const{name, email} =req.body;
    const user = await User.findById(req.userId);
    user.name = name;
    user.email = email;
    await user.save();
    res.json({name:user.name,email:user.email});
});
app.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});