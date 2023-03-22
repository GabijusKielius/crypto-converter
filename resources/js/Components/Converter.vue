<script>
import ConversionDisplay from "@/Components/ConversionDisplay.vue";

export default {
    data() {
        return {
            loading: false,
            message: null,
            from_amount: '',
            from_currency: '',
            to_currency: '',
            conversion: null,
        }
    },
    components: {ConversionDisplay},
    methods: {
        fetchCrypto() {
            if (!this.isFormFilled) {
                return;
            }
            this.conversion = null;
            this.loading = true;
            const data = {
                from_amount: this.from_amount,
                from_currency: this.from_currency,
                to_currency: this.to_currency
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
                    this.message = null;
                    this.conversion = data;
                })
                .catch(error => {
                    this.message = error;
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    computed: {
        isFormFilled() {
            return this.from_amount !== '' && this.from_currency !== '' && this.to_currency !== '';
        }
    }
}

</script>

<template>
    <div class="mt-16" >
        <div class="grid md:grid-cols-3 gap-6" @keydown.enter="fetchCrypto">
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Amount</h2>
                <input class="rounded-lg mt-3 p-2" v-model="from_amount" placeholder="Enter amount" type="number"/>
            </div>
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Currency</h2>
                <select class="rounded-lg mt-3" v-model="from_currency">
                    <option disabled value="">Please select currency</option>
                    <option>EUR</option>
                    <option>USD</option>
                    <option>PLN</option>
                </select>
            </div>
            <div class="p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Crypto Currency</h2>
                <input class="rounded-lg mt-3 p-2" v-model="to_currency" placeholder="Enter currency" />
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
        <conversion-display :conversion="conversion"></conversion-display>
    </div>
</template>
