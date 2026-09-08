const form = document.getElementById('form_data');

form.addEventListener('submit', function(e){
    //para hindi magload yung form natin pag click ng submit
    e.preventDefault(); 

    //kunin lahat ng laman ng form
    const form_data = new FormData(form);
    fetchData(form_data);
    
});

async function fetchData(form_data) {
        try {
                const response = await fetch(`${BASE_URL}example_to_controller`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // so CI3's is_ajax() sees this as ajax
                },
                body: form_data 
            });

            if (!response.ok) {
                throw new Error(`Server responded with ${response.status}`);
            }
            
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Fetch failed:', error);
        }
}

