<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {usePage} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import {ref} from 'vue';
import axios from 'axios';


const page = usePage();
const estudiante = page.props.estudiante;
const certificaciones = page.props.certificaciones;
const certificaciones_estudiante = page.props.certificaciones_estudiante;


const openModal = ref(false);
const selectedCertificacion = ref('');

const agregarCertificacion = async (event) => {
    try {
        if (!selectedCertificacion.value) {
            alert('Seleccione una certificación');
            return;
        }
        const formData = new FormData(event.target);
        const datos = {
            id_estudiante: parseInt(formData.get('id_estudiante')),
            id_certificacion: parseInt(formData.get('id_certificacion')),
        };

        console.log('Datos a enviar:', datos);

        await axios.post(route('estudiantes.certificaciones.store'), datos);
        alert('Certificacion Asignada correctamente');
        openModal.value = false;
        selectedCertificacion.value = '';
        location.reload();
    } catch (error) {
        console.error('Error al guardar:', error);
        alert(error);
    }
}


const getEstadoText = (estado_cert) => {
    const estados = {
        0: 'Pendiente',
        1: 'Aprobado',
        2: 'Rechazado'
    }
    return estados[estado_cert] || 'Estado desconocido'
}

</script>

<template>
    <Head title="Estudiantes"/>

    <AuthenticatedLayout>
        <template #header>

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Certificaciones de {{estudiante.nombre}}
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <button @click="openModal = true" class="px-4 py-3 bg-amber-500 text-white rounded hover:bg-amber-200">
                            + Agregar Curso al estudiante
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div v-if="Object. keys( certificaciones_estudiante ). length !== 0">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nombre Certificacion</th>
                                    <th scope="col" class="px-6 py-3">Estado</th>
                                    <th scope="col" class="px-6 py-3">Puntuacion Certificacion</th>
                                    <th scope="col" class="px-6 py-3">Puntuacion obtenida</th>
                                    <th scope="col" class="px-6 py-3">Fecha Eval/Cancelacion</th>
                                    <th scope="col" class="px-6 py-3">Evaluar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="est_cert in certificaciones_estudiante" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" >
                                    <th scope="col" class="px-6 py-3">{{ est_cert.certificacion.nombre}}</th>
                                    <th scope="col" class="px-6 py-3">{{ getEstadoText(est_cert.estado_cert) }}</th>
                                    <th scope="col" class="px-6 py-3">{{ est_cert.certificacion.puntaje_total }}</th>
                                    <th scope="col" class="px-6 py-3">{{ est_cert.puntaje ? est_cert.puntaje : 'sin evaluar' }}</th>
                                    <th scope="col" class="px-6 py-3">{{ est_cert.fecha_eval ? est_cert.fecha_eval : 'aun sin evaluar'}}</th>
                                    <th scope="col" class="px-6 py-3">
                                        <a
                                            :href="route('estudiantes.certificaciones.update', [est_cert.id_estudiante_cert, estudiante.id])"
                                            class="px-4 py-3 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors duration-200"
                                        >
                                            Evaluar
                                        </a>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-else>
                        <p>No hay Certificaciones registradas.</p>
                    </div>
                </div>
            </div>
        </div>





        <div v-if="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h3 class="text-lg font-bold mb-4">Agregar Certificacion</h3>
                <form @submit.prevent="agregarCertificacion">
                    <input type="hidden" name="id_estudiante" :value=estudiante.id>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Certificación</label>
                            <select v-model="selectedCertificacion"
                                    name="id_certificacion"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="" disabled selected>Seleccione una certificación</option>
                                <option v-for="certificacion in certificaciones"
                                        :key="certificacion.id"
                                        :value="certificacion.id">
                                    {{ certificacion.nombre }}
                                </option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="openModal = false"
                                    class="px-4 py-2 bg-gray-200 rounded-md">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>




    </AuthenticatedLayout>
</template>

