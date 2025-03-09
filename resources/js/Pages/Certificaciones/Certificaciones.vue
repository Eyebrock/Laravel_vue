<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {usePage} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import {ref} from 'vue';
import axios from 'axios';


const page = usePage();
const certificaciones = page.props.certificaciones;



const isModalOpen = ref(false);
const editandoEstudiante = ref(null);

const form = ref({
    nombre: '',
    puntaje_total: 0,
    id: null,
});


const openModal = (certificacion = null) => {
    if (certificacion) {
        editandoEstudiante.value = certificacion;
        form.value = { ...certificacion };
    } else {
        editandoEstudiante.value = null;
        form.value = { nombre: '', puntaje_total: 0, id: null };
    }
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.value = { nombre: '', puntaje_total: 0, id: null };
    editandoEstudiante.value = null;
};

const guardarEstudiante = async () => {
    try {
        if (form.value.id) {
            await axios.post(route('cursos.update', form.value.id), form.value);
            alert('Certificacion actualizado correctamente');
        } else {
            await axios.post(route('cursos.store'), form.value);
            alert('Certificacion registrada correctamente');
        }
        window.location.href = route('cursos');
        closeModal();
    } catch (error) {
        console.error('Error al guardar:', error);
        alert('Hubo un error al guardar la Certificacion.');
    }
};

const eliminarEstudiante = async (id) => {
    try {
        if (confirm('¿Estás seguro de que deseas eliminar esta Certificacion?')) {
            await axios.delete(route('cursos.destroy', id));
            alert('Certificacion eliminado correctamente');
            window.location.href = route('cursos');
        }
    } catch (error) {
        console.error('Error al eliminar:', error);
        alert('Hubo un error al eliminar el estudiante.');
    }
};
</script>

<template>
    <Head title="Estudiantes"/>

    <AuthenticatedLayout>
        <template #header>

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Lista de Certificaciones
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <button @click="openModal" class="px-4 py-3 bg-amber-500 text-white rounded hover:bg-amber-200">
                            + Agregar Certificacion
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
                    <div v-if="Object. keys( certificaciones ). length !== 0">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nombre</th>
                                    <th scope="col" class="px-6 py-3">Puntaje</th>
                                    <th scope="col" class="px-6 py-3">Actualizar</th>
                                    <th scope="col" class="px-6 py-3">Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="certificacion in certificaciones" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" >
                                    <th scope="col" class="px-6 py-3">{{ certificacion.nombre }}</th>
                                    <th scope="col" class="px-6 py-3">{{ certificacion.puntaje_total }}</th>
                                    <th scope="col" class="px-6 py-3"> <button @click="openModal(certificacion)" class="px-4 py-3 bg-amber-500 text-white rounded hover:bg-amber-200">
                                        Editar
                                    </button></th>
                                    <th scope="col" class="px-6 py-3"><button @click="eliminarEstudiante(certificacion.id)" class="px-4 py-3 bg-red-500 text-white rounded hover:bg-red-600">
                                        Eliminar
                                    </button></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-else>
                        <p>No hay Certificaciones Registradas.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal New-->
        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h3 class="text-lg font-bold mb-4">{{ editandoEstudiante.value ? 'Editar Certificacion' : 'Nueva Certificacion' }}</h3>

                <form @submit.prevent="guardarEstudiante">
                    <div class="mb-3">
                        <label class="block text-gray-700">Nombre</label>
                        <input
                            type="text"
                            v-model="form.nombre"
                            class="w-full px-3 py-2 border rounded"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="block text-gray-700">Puntaje (Maximo 100)</label>
                        <input
                            type="number"
                            v-model="form.puntaje_total"
                            class="w-full px-3 py-2 border rounded"
                            max="100"
                            required
                        />
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end mt-4">
                        <button
                            type="button"
                            @click="closeModal"
                            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-300 text-black rounded hover:bg-green-600"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

