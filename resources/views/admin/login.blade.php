
@extends('admin.layout')

@section('titre', 'Connexion')

@section('contenu')

<style>
.login-page{
    min-height:calc(100vh - 60px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 20px;
    background:linear-gradient(135deg,#0F172A,#1E3A8A);
}

.login-container{
    width:100%;
    max-width:1050px;
    display:grid;
    grid-template-columns:1fr 450px;
    border-radius:22px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 25px 70px rgba(0,0,0,.25);
}

.login-left{
    background:linear-gradient(135deg,#2563EB,#1D4ED8);
    color:white;
    padding:70px 55px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.login-left h1{
    font-size:42px;
    margin-bottom:20px;
    color:#fff;
}

.login-left p{
    font-size:16px;
    line-height:1.8;
    opacity:.95;
}

.login-right{
    padding:55px;
}

.login-logo{
    width:70px;
    height:70px;
    border-radius:18px;
    background:#2563EB;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    font-weight:bold;
    margin-bottom:20px;
}

.login-title{
    font-size:28px;
    font-weight:700;
    margin-bottom:6px;
}

.login-subtitle{
    color:#6B7280;
    margin-bottom:30px;
}

.input-group{
    position:relative;
    margin-bottom:18px;
}

.input-group input{
    width:100%;
    height:52px;
    padding:0 18px;
    border-radius:12px;
    border:1px solid #D1D5DB;
    background:#F9FAFB;
    transition:.25s;
}

.input-group input:focus{
    border-color:#2563EB;
    outline:none;
    background:white;
    box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

.login-btn{
    width:100%;
    height:52px;
    border:none;
    border-radius:12px;
    background:#2563EB;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.25s;
}

.login-btn:hover{
    background:#1D4ED8;
}

.login-footer{
    margin-top:25px;
    text-align:center;
    color:#9CA3AF;
    font-size:13px;
}

@media(max-width:900px){

.login-container{
grid-template-columns:1fr;
}

.login-left{
display:none;
}

.login-right{
padding:35px;
}

}
</style>

<div class="login-page">

<div class="login-container">

<div class="login-left">

<h1>Administration</h1>

<p>

Bienvenue dans le système de gestion des licences.

Connectez-vous afin d'administrer les entreprises, les licences et les appareils autorisés.

</p>

</div>

<div class="login-right">

<div class="login-logo">
L
</div>

<div class="login-title">
Connexion
</div>

<div class="login-subtitle">
Accédez à votre espace administrateur.
</div>

@if ($errors->any())
<div class="alerte-erreur">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('admin.login.submit') }}">

@csrf

<label>Email</label>

<div class="input-group">
<input
type="email"
name="email"
value="{{ old('email') }}"
placeholder="exemple@entreprise.com"
required
autofocus>
</div>

<label>Mot de passe</label>

<div class="input-group">
<input
type="password"
name="password"
placeholder="Votre mot de passe"
required>
</div>

<button class="login-btn">

Se connecter

</button>

</form>

<div class="login-footer">

© {{ date('Y') }} Gestion des licences

</div>

</div>

</div>

</div>

@endsection
