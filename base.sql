sqlite3 fitspace.db

Create table users (
    id integer primary key autoincrement,
    nom text not null,
    email text not null unique,
    password text not null,
    role text not null,
    created_at datetime default current_timestamp
);

Create table ressources (
    id integer primary key autoincrement,
    nom text not null,
    type text not null,
    capacite integer not null,
    description text
);

Create table creneaux (
    id integer primary key autoincrement, 
    ressources_id integer not null,
    date_debut datetime not null,
    date_fin datetime not null,
    places_dispo integer not null,
    actif boolean default true,
    foreign key (ressources_id) references ressources(id)
);

Create table reservations (
    id integer primary key autoincrement,
    users_id integer not null,
    creneaux_id integer not null,
    statut text default 'en_attente',
    foreign key (users_id) references users(id),
    foreign key (creneaux_id) references creneaux(id)
);