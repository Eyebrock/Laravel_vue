<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {usePage} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import {ref} from 'vue';
import axios from 'axios';

const page = usePage();
const estudiante = page.props.estudiante;
const estudiante_certificacion = page.props.estudiante_certificacion;


const formData = ref({
    estado_cert: estudiante_certificacion?.estado_cert ?? 0,
    puntaje: estudiante_certificacion?.puntaje ?? 0,
    id_estudiante: estudiante?.id ?? 0,
    id_certificacion: estudiante_certificacion?.id_certificacion ?? 0,
    id_estudiante_cert: estudiante_certificacion?.id_estudiante_cert ?? 0
});


const actualizarPuntajePorEstado = (estado_cert) => {
    if (estado_cert !== 1) {
        formData.value.puntaje = 0;
    }
};


const agregarCertificacion = async () => {
    try {

        if (formData.value.estado_cert === 2) {
            formData.value.puntaje = 0;
        }

        if (formData.value.estado_cert === 0) {
            formData.value.puntaje = 0;
        }


        console.log('Datos a enviar:', formData.value);
        await axios.post(route('estudiantes.certificaciones.update.store'), formData.value);
        formData.value.puntaje = ''; // Limpiar después de enviar
        window.location.href = route('certificaciones_estudiante', estudiante.id);
    } catch (error) {
        console.error('Error al agregar certificación:', error);
        alert(error);
    }
};
</script>

<template>
    <Head title="Estudiantes"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Certificaciones de {{ estudiante.nombre }}
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="agregarCertificacion" class="space-y-4 p-6">
                        <!-- Campos ocultos para mantener la información -->
                        <input type="hidden" name="id_estudiante" :value="estudiante?.id ?? 0">
                        <input type="hidden" name="id_certificacion" :value="estudiante_certificacion?.id_certificacion ?? 0">
                        <input type="hidden" name="id_estudiante_cert" :value="estudiante_certificacion?.id_estudiante_cert ?? 0">

                        <!-- Select para el estado -->
                        <div class="flex flex-col space-y-2">
                            <label for="estado_cert" class="text-sm font-medium">Estado:</label>
                            <select
                                id="estado_cert"
                                v-model="formData.estado_cert"
                                @change="actualizarPuntajePorEstado(formData.estado_cert)"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="0">Pendiente</option>
                                <option value="1">Aprobado</option>
                                <option value="2">Rechazado</option>
                            </select>
                        </div>

                        <!-- Campo puntaje condicional -->
                        <div class="flex flex-col space-y-2" v-if="formData.estado_cert === '1'">
                            <label for="puntaje" class="text-sm font-medium">Puntaje:</label>
                            <input
                                id="puntaje"
                                v-model.number="formData.puntaje"
                                type="number"
                                min="0"
                                max="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto"
                        >
                            Validar certificación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
