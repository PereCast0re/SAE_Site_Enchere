import requests
import mysql.connector

headers = {
    "User-Agent": "JimmyBot/1.0 (localhost; jimmy.garnier1110@gmail.com)"
}

def save_celebrities(celebrities):
    db = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="auction_site",
        charset="utf8mb4"
    )

    cursor = db.cursor()

    sql = """
    INSERT INTO celebrity (name, url)
    VALUES (%s, %s)
    """

    for celeb in celebrities:
        cursor.execute(sql, (
            celeb["name"],
            celeb.get("url") # Renvoie la valeur si elle existe sans erreur
        ))

    db.commit()
    cursor.close()
    db.close()

def getId(title):
    url = f"https://www.wikidata.org/w/api.php?action=wbsearchentities&language=fr&search={title}&format=json"
    response = requests.get(url, headers=headers)
    data = response.json()

    if "search" not in data or len(data["search"]) == 0:
        return None

    return data["search"][0]["id"]


def isHuman(wikidata_id):
    if wikidata_id is None:
        return False

    url = f"https://www.wikidata.org/w/api.php?action=wbgetentities&ids={wikidata_id}&props=claims&format=json"
    response = requests.get(url, headers=headers)
    data = response.json()

    claims = data["entities"][wikidata_id]["claims"]

    if "P31" not in claims:
        return False

    for claim in claims["P31"]:
        value = claim["mainsnak"]["datavalue"]["value"]["id"]
        if value == "Q5":
            return True

    return False


def getUrl(wikidata_id):
    url = f"https://www.wikidata.org/w/api.php?action=wbgetentities&ids={wikidata_id}&props=claims&format=json"
    response = requests.get(url, headers=headers)
    data = response.json()

    claims = data["entities"][wikidata_id]["claims"]

    if "P18" not in claims:
        return None

    filename = claims["P18"][0]["mainsnak"]["datavalue"]["value"]

    # Récupérer l'URL de l'image
    url = f"https://commons.wikimedia.org/w/api.php?action=query&titles=File:{filename}&prop=imageinfo&iiprop=url&format=json"
    response = requests.get(url, headers=headers)
    data = response.json()

    page = next(iter(data["query"]["pages"].values()))

    if "imageinfo" not in page:
        return None

    return page["imageinfo"][0]["url"]

try:
    themes = ["acteur", "realisateur", "chanteur", "musicien", "footballeur", "sportif", "influenceur", "youtuber", "animateur TV", "personnalite mediatique", "mannequin", "homme politique"]

    celebrities = []

    actualLen = 1 # limite
    
    for theme in themes:    
        url = f"https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch={theme}&format=json&sroffset=50"
        response = requests.get(url, headers=headers, timeout=15)
        data = response.json()
        # print(data)
        # actualLen = data['query']['searchinfo']['totalhits']
        print(url)
        # print(len(data['query']['search'])) 
        for x in range(0, actualLen, 10): # boucle tous les 10 car c'est la limite de l'API
            url = f"https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch={theme}&format=json&sroffset={x}"
            response = requests.get(url, headers=headers, timeout=15)
            data = response.json()
            for i in data["query"]["search"]:
                name = i["title"]
                iID = getId(name)
                if name not in [c["name"] for c in celebrities] and isHuman(iID):                
                    celebrities.append({"name": i["title"], "url": getUrl(iID)})
                
    url = "https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=acteur&format=json&sroffset=50"
    response = requests.get(url, headers=headers, timeout=15)
    data = response.json()
            
    print(celebrities)
    
    print("Nombre attendu de personnes : " + str(len(themes) * actualLen) + "| Nombre actuel : " + str(len(celebrities)))
    
    save_celebrities(celebrities)

except requests.exceptions.ConnectionError:
    print("Erreur de connexion")
except requests.exceptions.Timeout:
    print("Délai d’attente dépassé")
except requests.exceptions.RequestException as e:
    print(f"Erreur générale : {e}")