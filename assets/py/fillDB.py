import csv
import psycopg2

# Configuration de la base de données
DB_SERVER = '172.20.0.2'
DB_PORT = '5432'
DB_USER = 'yanis'
DB_PASSWORD = 'a'
DB_NAME = 'db'

# Chemin vers votre fichier CSV
csv_file_path = 'data_clean.csv'

def convert_na(value):
    if value == "NA":
        return None
    return value

# Connexion à la base de données PostgreSQL
conn = psycopg2.connect(
    dbname=DB_NAME,
    user=DB_USER,
    password=DB_PASSWORD,
    host=DB_SERVER,
    port=DB_PORT
)

cursor = conn.cursor()

# Créer la table boat
create_boat_table_sql = """
CREATE TABLE IF NOT EXISTS boat (
    mmsi BIGINT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    length DOUBLE PRECISION NOT NULL,
    width DOUBLE PRECISION NOT NULL,
    draft DOUBLE PRECISION NOT NULL
);
"""
cursor.execute(create_boat_table_sql)

# Créer la table position
create_position_table_sql = """
CREATE TABLE IF NOT EXISTS position (
    id_pos SERIAL PRIMARY KEY,
    basedatetime TIMESTAMP NOT NULL,
    latitude DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
    sog DOUBLE PRECISION NOT NULL,
    cog DOUBLE PRECISION NOT NULL,
    heading INTEGER NOT NULL,
    "status" INTEGER,
    prediction BOOLEAN NOT NULL DEFAULT FALSE,
    mmsi BIGINT NOT NULL,
    FOREIGN KEY (mmsi) REFERENCES boat(mmsi)
);
"""
cursor.execute(create_position_table_sql)

# Lire le fichier CSV et insérer les données dans les tables boat et position
with open(csv_file_path, newline='', encoding='utf-8') as csvfile:
    csv_reader = csv.DictReader(csvfile)

    for row in csv_reader:
        # Insérer dans la table boat
        boat_insert_sql = """
        INSERT INTO boat (mmsi, name, length, width, draft)
        VALUES (%s, %s, %s, %s, %s)
        ON CONFLICT (mmsi) DO NOTHING;
        """
        boat_data = (
            row['MMSI'],
            row['VesselName'],
            convert_na(row['Length']),
            convert_na(row['Width']),
            convert_na(row['Draft'])
        )
        cursor.execute(boat_insert_sql, boat_data)

        # Insérer dans la table position
        position_insert_sql = """
        INSERT INTO position (basedatetime, latitude, longitude, sog, cog, heading, "status", mmsi)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s);
        """
        position_data = (
            row['BaseDateTime'],
            convert_na(row['LAT']),
            convert_na(row['LON']),
            convert_na(row['SOG']),
            convert_na(row['COG']),
            convert_na(row['Heading']),
            convert_na(row['Status']),
            row['MMSI']
        )
        cursor.execute(position_insert_sql, position_data)

# Valider les changements et fermer la connexion
conn.commit()
cursor.close()
conn.close()

print("Tables créées et données insérées avec succès dans la base de données.")

