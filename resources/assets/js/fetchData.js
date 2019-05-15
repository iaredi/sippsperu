export default async function fetchData(url, body) {
    
    const myapi = `${location.protocol}//${window.location.host}/api/${url}`;
    const rawResponse = await fetch(myapi, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json;",
            mode: "cors"
        },
        body: JSON.stringify(body)
    });
    let dataResult = await rawResponse.json();
    return dataResult;
}
