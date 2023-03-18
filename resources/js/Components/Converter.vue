<script>

export default {
    data() {
        return {
            loading: false,
            message: null,
            amount: '',
            currencyMoney: '',
            currencyCrypto: '',
        }
    },
    methods: {
        fetchCrypto() {
            if (!this.isFormFilled) {
                return;
            }
            this.loading = true;
            const data = {
                amount: this.amount,
                currency_money: this.currencyMoney,
                currency_crypto: this.currencyCrypto
            };

            fetch("/api/currency/convert", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if(!response.ok) {
                        return response.json().then(text => { throw new Error(text.message) })
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    this.message = null;
                })
                .catch(error => {
                    this.message = error;
                });
        }
    },
    computed: {
        isFormFilled() {
            return this.amount !== '' && this.currencyMoney !== '' && this.currencyCrypto !== '';
        }
    }
}

</script>

<template>
    <div class="mt-16" >
        <div class="grid md:grid-cols-3 gap-6" @keydown.enter="fetchCrypto">
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Amount</h2>
                <input class="rounded-lg mt-3 p-2" v-model="amount" placeholder="Enter amount" type="number"/>
            </div>
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Currency</h2>
                <select class="rounded-lg mt-3" v-model="currencyMoney">
                    <option disabled value="">Please select currency</option>
                    <option>EUR</option>
                    <option>USD</option>
                    <option>PLN</option>
                </select>
            </div>
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Crypto Currency</h2>
                <input class="rounded-lg mt-3 p-2" v-model="currencyCrypto" placeholder="Enter currency" />
            </div>
        </div>
        <div class="mt-5 flex justify-center">
            <button
                :disabled="!isFormFilled"
                type="submit"
                class="disabled:opacity-25 p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl"
                @click="fetchCrypto"
            >
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Submit</h2>
            </button>
        </div>
        <div v-if="message">
            <p class="flex justify-center text-red-600">{{ message }}</p>
        </div>
    </div>
</template>
