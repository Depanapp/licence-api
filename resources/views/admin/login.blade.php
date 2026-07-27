@extends('admin.layout')

@section('titre', 'Connexion')

@section('contenu')

<div class="login-container">

    <div class="login-card">

        <div class="login-header">
            <div class="logo">
                <span>🔐</span>
            </div>

            <h1>Administration</h1>
            <p>
                Gestion des entreprises et des licences
            </p>
        </div>


        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif


        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf


            <div class="input-group">
                <label for="email">
                    Adresse email
                </label>

                <div class="input-box">
                    <span>✉️</span>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="admin@example.com"
                        required
                        autofocus
                    >
                </div>
            </div>



            <div class="input-group">
                <label for="password">
                    Mot de passe
                </label>

                <div class="input-box">
                    <span>🔒</span>

                    <input 
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Votre mot de passe"
                        required
                    >
                </div>
            </div>



            <button type="submit" class="login-button">
                Se connecter
                <span>→</span>
            </button>


        </form>


        <div class="footer-text">
            © {{ date('Y') }} - Gestion Licence
        </div>

    </div>

</div>


<style>

*{
    box-sizing:border-box;
}


.login-container{

    min-height:80vh;

    display:flex;

    justify-content:center;

    align-items:center;

    background:
    linear-gradient(
        135deg,
        #0f172a,
        #1e293b
    );

    padding:30px;

}



.login-card{

    width:400px;

    background:white;

    border-radius:25px;

    padding:40px;

    box-shadow:
    0 20px 50px rgba(0,0,0,.25);

    animation:slide .5s ease;

}



@keyframes slide{

from{
    opacity:0;
    transform:translateY(30px);
}

to{
    opacity:1;
    transform:translateY(0);
}

}



.login-header{

    text-align:center;

    margin-bottom:30px;

}



.logo{

    width:75px;

    height:75px;

    margin:auto;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:
    linear-gradient(
        135deg,
        #d4af37,
        #f7d774
    );

    font-size:35px;

}



.login-header h1{

    margin-top:20px;

    font-size:28px;

    color:#0f172a;

}



.login-header p{

    color:#64748b;

    font-size:14px;

}



.input-group{

    margin-bottom:20px;

}



.input-group label{

    display:block;

    margin-bottom:8px;

    color:#334155;

    font-weight:600;

}



.input-box{

    display:flex;

    align-items:center;

    gap:10px;

    border:1px solid #cbd5e1;

    padding:0 15px;

    border-radius:12px;

    transition:.3s;

}



.input-box:focus-within{

    border-color:#d4af37;

    box-shadow:
    0 0 0 3px rgba(212,175,55,.15);

}



.input-box span{

    font-size:18px;

}



.input-box input{

    width:100%;

    padding:14px 5px;

    border:none;

    outline:none;

    font-size:15px;

}



.login-button{

    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    cursor:pointer;

    color:white;

    font-size:16px;

    font-weight:bold;

    display:flex;

    justify-content:center;

    gap:10px;

    background:
    linear-gradient(
        135deg,
        #d4af37,
        #b8860b
    );

    transition:.3s;

}



.login-button:hover{

    transform:translateY(-3px);

    box-shadow:
    0 10px 25px rgba(212,175,55,.4);

}



.alert-error{

    background:#fee2e2;

    color:#991b1b;

    padding:12px;

    border-radius:10px;

    margin-bottom:20px;

    text-align:center;

}



.footer-text{

    margin-top:25px;

    text-align:center;

    color:#94a3b8;

    font-size:13px;

}


</style>

@endsection