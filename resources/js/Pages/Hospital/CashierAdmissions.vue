<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    admissions: Object
});

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Admissions" />
        <div class="main-content max-w-6xl mx-auto sm:px-6 lg:px-8 mt-10">

            <!-- Start::row-1 -->
            <div class="grid grid-cols-12">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box  overflow-hidden">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                All Admissions
                            </div>

                        </div>
                        <div class="box-body !p-0">
                            <div class="table-responsive">

                                <table class="table table-hover whitespace-nowrap min-w-full">
                                    <thead>
                                        <tr>
                                            <th scope="row" class="!ps-6">#</th>
                                            <th scope="col" class="text-start">Names</th>
                                            <th scope="col" class="text-start">Gender</th>
                                            <th scope="col" class="text-start">Age</th>
                                            <th scope="col" class="text-start">Admission date</th>
                                            <th scope="col" class="text-start">Signs</th>
                                            <th scope="col" class="text-start">Diagnosis</th>
                                            <th scope="col" class="text-start">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(admission, index) in admissions.data" :key="index"
                                            class="border-t hover:bg-gray-200 dark:hover:bg-light">
                                            <td class="!ps-6">{{ index + 1 }}</td>
                                            <td>{{ `${admission.first_name} ${admission.last_name} ` }}</td>
                                            <td>{{ admission.gender }}</td>
                                            <td>{{ admission.age }}</td>
                                            <td>{{ admission.date }}</td>
                                            <td>
                                                <strong>Blood Pressure :</strong> {{ admission.signs.blood_pressure }} ,
                                                <strong>Temperature :</strong> {{ admission.signs.temperature }} ,
                                                <strong>Respiration :</strong> {{ admission.signs.respiration }}
                                            </td>
                                            <td>{{ admission.patient_data.diagnosis }}</td>
                                            <td>{{ admission.price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--End::row-1 -->

        </div>

    </AuthenticatedLayout>
</template>
