const base_api_url = 'https://localhost/studiomfotografia/api';

function fetch_get(url) {
  return fetch(base_api_url + url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
}

function fetch_post(url, params) {
  return fetch(base_api_url + url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(params)
  })
  .then(response => response.json()) 
  .catch(err => console.log(err));
}