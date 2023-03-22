<script>
import Loader from "@/Components/Loader.vue";

export default {
    props: {
        conversion: {}
    },
    components: {Loader},
    data(){
        return {
            isLoading: true
        }
    }
}

</script>

<template>
    <div class="mt-5 flex justify-center">
        <div class="disabled:opacity-25 p-6 dark:bg-gray-800/50 dark:ring-1 dark:ring-inset rounded-lg shadow-2xl justify-center conversion-display">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white text-center pb-5">Result</h2>
            <div v-if="!$parent.loading" class="flex justify-center">
                <table>
                    <tr class="text-gray-400">
                        <th class="pr-4 pl-4">Currency</th>
                        <th class="pr-4 pl-4">Amount</th>
                    </tr>
                    <tr class="dark:text-white text-center">
                        <td>{{ (conversion && conversion.to_currency) ? conversion.to_currency : 'N/A' }}</td>
                        <td>{{ (conversion && conversion.to_amount) ? conversion.to_amount : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            <div v-else class="flex justify-center">
                <loader></loader>
            </div>
        </div>
    </div>
</template>

<style scoped>
.conversion-display {
    min-width: 300px;
    min-height: 160px;
}
</style>
