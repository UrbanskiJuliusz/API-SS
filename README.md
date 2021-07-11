# API-SS

## Entries

<table>
<tr>
  <th>METODA</th>
  <th>ENDPOINT</th>
  <th>DANE_WEJŚCIOWE</th>
</tr>
<tr>
  <td>GET</td>
  <td>/api/entries</td>
  <td>BRAK</td>
</tr>
<tr>
  <td>GET</td>
  <td>/api/entry/{id_wpisu}</td>
  <td>BRAK</td>
</tr> 
<tr>
  <td>POST</td>
  <td>/add-entry</td>
  <td>
  {
    "categoryId": 1,
    "companyName": "Nazwa firmy",
    "www": "Adres strony internetowej",
    "address": "Adres",
    "content": "Opis",
    "created": "2021-07-10 18:46:10"
  }
  </td>
</tr>
<tr>
  <td>PUT</td>
  <td>/api/update-entry/{id_wpisu}</td>
  <td>
  {
    "categoryId": 1,
    "companyName": "Nazwa firmy",
    "www": "Adres strony internetowej",
    "address": "Adres",
    "content": "Opis",
    "created": "2021-07-10 18:46:10"
  }
  </td>
</tr>
<tr>
  <td>DELETE</td>
  <td>/api/del-entry/{id_wpisu}</td>
  <td>BRAK</td>
</tr>
</table>

## Category

<table>
<tr>
  <th>METODA</th>
  <th>ENDPOINT</th>
  <th>DANE_WEJŚCIOWE</th>
</tr>
<tr>
  <td>GET</td>
  <td>/api/categories</td>
  <td>BRAK</td>
</tr>  
<tr>
  <td>GET</td>
  <td>/api/category/{id_kategorii}</td>
  <td>BRAK</td>
</tr>     
<tr>
  <td>POST</td>
  <td>/api/add-category</td>
  <td>
  { 
    "name": "Nazwa firmy",
    "orderView": 1
  }
  </td>
</tr>  
<tr>
  <td>PUT</td>
  <td>/api/update-category/{id_kategorii}</td>
  <td>
  {
    "name": "Nazwa firmy",
    "orderView": 2
  }
  </td>
</tr>    
<tr>
  <td>DELETE</td>
  <td>/api/del-category/{id_kategorii}</td>
  <td>BRAK</td>
</tr>
</table>
