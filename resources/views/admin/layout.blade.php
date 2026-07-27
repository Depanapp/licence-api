<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
@yield('titre', 'Administration') — Licences
</title>


<style>

:root{

--primary:#2563eb;
--dark:#0f172a;
--dark2:#111827;

--background:#f8fafc;

--card:#ffffff;

--border:#e5e7eb;

--text:#1e293b;

--muted:#64748b;

--success:#16a34a;

--danger:#dc2626;

}



*{

box-sizing:border-box;

}



body{

margin:0;

font-family:
Inter,
-apple-system,
BlinkMacSystemFont,
"Segoe UI",
Roboto,
sans-serif;

background:var(--background);

color:var(--text);

}



/* ================= HEADER ================= */


.header{


height:70px;

background:
linear-gradient(
135deg,
#0f172a,
#1e293b
);


color:white;

display:flex;

align-items:center;

justify-content:space-between;

padding:0 30px;

box-shadow:
0 5px 20px rgba(0,0,0,.15);


}



.logo{

font-size:18px;

font-weight:800;

display:flex;

align-items:center;

gap:10px;

}



.logo span{

background:#2563eb;

width:38px;

height:38px;

display:flex;

align-items:center;

justify-content:center;

border-radius:12px;

}



nav{

display:flex;

align-items:center;

gap:20px;

}



nav a{

color:#cbd5e1;

text-decoration:none;

font-size:14px;

}



nav a:hover{

color:white;

}




.logout{

background:#ffffff10;

border:1px solid #ffffff30;

padding:8px 15px;

border-radius:10px;

color:white;

cursor:pointer;

}



/* MENU MOBILE */


.menu-btn{

display:none;

font-size:25px;

cursor:pointer;

}



/* ================= MAIN ================= */



main{

max-width:1200px;

margin:auto;

padding:35px;

}



h1{

font-size:26px;

margin-bottom:5px;

}



.sous-titre{

color:var(--muted);

margin-bottom:25px;

}



/* CARTE */


.carte{


background:white;

border-radius:20px;

padding:25px;

border:1px solid var(--border);

box-shadow:

0 10px 30px rgba(15,23,42,.05);

margin-bottom:25px;

}




/* ALERTES */


.alerte-succes,
.alerte-erreur{


padding:15px;

border-radius:14px;

margin-bottom:20px;

font-size:14px;

}


.alerte-succes{

background:#dcfce7;

color:#166534;

}


.alerte-erreur{

background:#fee2e2;

color:#991b1b;

}



/* FORMULAIRE */


label{

font-size:13px;

font-weight:700;

color:#475569;

display:block;

margin-bottom:7px;

}



input,
select{


width:100%;

padding:13px 15px;

border-radius:12px;

border:1px solid var(--border);

background:#f8fafc;

font-size:14px;

outline:none;

transition:.3s;

}



input:focus,
select:focus{

border-color:var(--primary);

box-shadow:
0 0 0 4px #2563eb20;

}




.grille-2{

display:grid;

grid-template-columns:1fr 1fr;

gap:20px;

}



/* BUTTON */


.bouton{


background:linear-gradient(
135deg,
#2563eb,
#1d4ed8
);


color:white;

border:none;

padding:13px 20px;

border-radius:12px;

font-weight:700;

cursor:pointer;

transition:.3s;

}



.bouton:hover{

transform:translateY(-2px);

box-shadow:
0 10px 20px #2563eb40;

}




.bouton-danger{

background:#dc2626;

}




/* TABLE */


.table-container{

overflow-x:auto;

}



table{

width:100%;

border-collapse:collapse;

}



th{

font-size:12px;

color:#64748b;

text-transform:uppercase;

padding:14px;

text-align:left;

}



td{

padding:14px;

border-top:1px solid var(--border);

}



tr:hover{

background:#f8fafc;

}




.badge{

padding:5px 12px;

border-radius:20px;

font-size:12px;

font-weight:700;

}


.badge-active{

background:#dcfce7;

color:#16a34a;

}



.badge-expiree{

background:#fef3c7;

color:#b45309;

}



/* ================= MOBILE ================= */


@media(max-width:768px){


.header{

padding:0 20px;

}



.menu-btn{

display:block;

}


nav{

position:absolute;

top:70px;

left:0;

right:0;

background:#0f172a;

display:none;

flex-direction:column;

padding:25px;

}


nav.active{

display:flex;

}



main{

padding:20px;

}



h1{

font-size:22px;

}



.carte{

padding:18px;

border-radius:15px;

}



.grille-2{

grid-template-columns:1fr;

}



table{

font-size:13px;

}



}


</style>

</head>



<body>


@auth


<header class="header">


<div class="logo">

<span>🔐</span>

Gestion Licences

</div>



<div class="menu-btn"
onclick="toggleMenu()">

☰

</div>



<nav id="menu">


<a href="{{route('admin.dashboard')}}">
📄 Licences
</a>


<a href="{{route('admin.entreprises.create')}}">
🏢 Entreprise
</a>


<form method="POST"
action="{{route('admin.logout')}}">

@csrf

<button class="logout">
Déconnexion
</button>


</form>


</nav>


</header>


@endauth




<main>


@if(session('succes'))

<div class="alerte-succes">

{{session('succes')}}

</div>

@endif



@if(session('erreur'))

<div class="alerte-erreur">

{{session('erreur')}}

</div>

@endif



@yield('contenu')


</main>



<script>

function toggleMenu(){

document
.getElementById('menu')
.classList.toggle('active');

}

</script>


@stack('scripts')


</body>

</html>