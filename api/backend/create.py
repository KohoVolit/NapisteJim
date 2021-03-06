# creates data.json from http://www.psp.cz/sqw/hp.sqw?k=1300

import csv
import io
import json
import locale
import requests
import zipfile
import os

# path
# try:
#     path = os.path.dirname(os.path.realpath(__file__))
# except Exception:
#     path = os.getcwd()

path = 'api/backend/'
term = '172'
group_number = '1'
region_number = '75'
memberships = {
    'commissions': "2",
    "committees": "3",
    "delegations": "7"
}

# download

url = "https://www.psp.cz/eknih/cdrom/opendata/poslanci.zip"
r = requests.get(url)
if r.ok:
    z = zipfile.ZipFile(io.BytesIO(r.content))
    z.extractall(path)

# prepare data
locale.setlocale(locale.LC_ALL, 'cs_CZ.UTF-8')
poslanec = {}
organy = {}
osoby = {}
zarazeni = []
data_obj = {}
data_all_obj = {}
data = []
data_all = []
with open(path + "poslanec.unl", encoding="cp1250") as fin:
    csvr = csv.reader(fin, delimiter='|')
    for row in csvr:
        poslanec[row[0]] = row

with open(path + "organy.unl", encoding="cp1250") as fin:
    csvr = csv.reader(fin, delimiter='|')
    for row in csvr:
        organy[row[0]] = row

with open(path + "osoby.unl", encoding="cp1250") as fin:
    csvr = csv.reader(fin, delimiter='|')
    for row in csvr:
        osoby[row[0]] = row

with open(path + "zarazeni.unl", encoding="cp1250") as fin:
    csvr = csv.reader(fin, delimiter='|')
    for row in csvr:
        zarazeni.append(row)

# snemovna
for row in zarazeni:
    if row[1] == term and row[4] == '':
        data_obj[row[0]] = {
            "id": row[0],
            "committees": [],
            "delegations": [],
            "commissions": []
        }
    if row[1] == term:
        data_all_obj[row[0]] = {
            "id": row[0],
            "committees": [],
            "delegations": [],
            "commissions": []
        }

# kluby
groups = []
for k in organy:
    if organy[k][1] == term and organy[k][2] == group_number:
        groups.append(organy[k][0])


for row in zarazeni:
    if row[1] in groups and row[4] == '':
        data_obj[row[0]]['group'] = organy[row[1]][3]
        data_all_obj[row[0]]['group'] = organy[row[1]][3]

# regions, emails, names
regions = []
for k in organy:
    if organy[k][2] == region_number:
        regions.append(organy[k][0])

poslanec2 = {}
for k in poslanec:
    if poslanec[k][4] == term:
        poslanec2[poslanec[k][1]] = poslanec[k]

for k in data_obj:
    data_obj[k]['region'] = organy[poslanec2[k][2]][4]
    data_obj[k]['email'] = poslanec2[k][9]
    data_obj[k]['name'] = osoby[k][3] + " " + osoby[k][2]
    data_obj[k]['family_name'] = osoby[k][2]
    data_obj[k]['given_name'] = osoby[k][3]
    data_obj[k]['mp_id'] = poslanec2[k][0]

for k in data_all_obj:
    data_all_obj[k]['region'] = organy[poslanec2[k][2]][4]
    data_all_obj[k]['email'] = poslanec2[k][9]
    data_all_obj[k]['name'] = osoby[k][3] + " " + osoby[k][2]
    data_all_obj[k]['family_name'] = osoby[k][2]
    data_all_obj[k]['given_name'] = osoby[k][3]
    data_all_obj[k]['mp_id'] = poslanec2[k][0]

# other memberships
for m in memberships:
    ids = []
    for k in organy:
        if organy[k][1] == term and organy[k][2] == memberships[m]:
            ids.append(organy[k][0])

    for row in zarazeni:
        if row[1] in ids and row[4] == '':
            try:
                data_obj[row[0]][m].append(organy[row[1]][4])
                data_all_obj[row[0]][m].append(organy[row[1]][4])
            except Exception as e:
                print(e)

for k in data_obj:
    data.append(data_obj[k])

for k in data_all_obj:
    data_all.append(data_all_obj[k])

data = sorted(sorted(data, key=lambda x: locale.strxfrm(x['given_name'])), key=lambda x: locale.strxfrm(x['family_name']))
data_all = sorted(sorted(data_all, key=lambda x: locale.strxfrm(x['given_name'])), key=lambda x: locale.strxfrm(x['family_name']))


with open(path + "../data.json", "w") as fout:
    json.dump(data, fout, ensure_ascii=False)

with open(path + "../data_all.json", "w") as fout:
    json.dump(data_all, fout, ensure_ascii=False)
