<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Practicas Profesionales</title>
    <!-- librerias de front-end -->
    <?php include('../componentes/vueKit.php'); ?>
    <!-- librerias de front-end -->
    <link rel="stylesheet" href="../css/paginaPrincipal.css">
</head>
<body>
    <div id="gestion">
        <v-card class="mx-auto" :class="[`elevation-0`]" max-width="900">
            <v-layout>
                <v-app-bar color="#6a1c37">

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ nombreMaestro }} - {{ puesto }} - {{ turno }}
                            <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item value="2">
                                <template v-slot:prepend>
                                    <v-icon>mdi-account-off </v-icon>
                                </template>
                                
                                <v-list-item-title @click="CerrarSesion">Cerrar sesión</v-list-item-title>
                                 
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                        <v-row dense>
                            <v-col>
                                <v-card class="mx-auto" :class="[`elevation-5`]" v-if="vista == 0">
                                    <div>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" xs="1" sm="6">
                                                    <v-text-field
                                                    variant="solo"
                                                    label="Buscar alumno"
                                                    density="compact"
                                                    prepend-inner-icon="mdi-magnify"
                                                    v-model="buscarAlumno"
                                                    >
                                                    </v-text-field>
                                                </v-col>
                                                <v-col cols="12" xs="1" sm="6" class="d-flex justify-end">
                                                    <v-switch label="Sin servicio" color="#6a1c37" inset v-model="sinServicio"></v-switch>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </div>
                                    <div
                                        class="container-list-instituciones"
                                    >
                                        <v-list-item
                                            v-for="alumno, i in cpmAlumnos"
                                            :key="i"
                                            :title="alumno.nombre_completo"
                                            class="style-item-list"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    style="margin-right: 5px;"
                                                    icon="mdi-file-document-multiple-outline"
                                                    variant="tonal"
                                                    @click="seeDocuments(alumno.numero_control)"
                                                >
                                                </v-btn>
                                                <v-btn
                                                    style="margin-right: 5px;"
                                                    icon="mdi-circle-edit-outline"
                                                    variant="tonal"
                                                    @click="vista = 2"
                                                >
                                            </template>
                                        </v-list-item>
                                    </div>
                                </v-card>
                                <v-card class="mx-auto" :class="[`elevation-5`]" v-if="vista == 1">
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCconstancia_temino_servicio"
                                            :key="documento.id"
                                            :title="'Constancia de termino del servicio social'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCsolicitud"
                                            :key="documento.id"
                                            :title="'Constancia de termino del servicio social'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCcarta_precentacion"
                                            :key="documento.id"
                                            :title="'Constancia de termino del servicio social'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>

                                    <v-expansion-panels
                                    v-model="panel"
                                    multiple
                                    v-if="DOCfirmado.length > 0"
                                    >
                                        <v-expansion-panel>
                                            <v-expansion-panel-title>Informes</v-expansion-panel-title>
                                            <v-expansion-panel-text>
                                                <v-list lines="one">
                                                    <v-list-item
                                                        v-for="documento in DOCfirmado"
                                                        :key="documento.id"
                                                        :title="documento.proceso"
                                                        :subtitle="documento.nombre_documento"
                                                    >
                                                        <template v-slot:append>
                                                            <v-btn
                                                                icon="mdi-download-circle-outline"
                                                                variant="tonal"
                                                            ></v-btn>
                                                        </template>
                                                    </v-list-item>
                                                </v-list>
                                            </v-expansion-panel-text>
                                        </v-expansion-panel>
                                    </v-expansion-panels>

                                    <div class="d-flex justify-center" style="margin-top: 10px; margin-bottom: 10px;">
                                        <v-btn icon="mdi-arrow-left" @click="vista = 0"></v-btn>
                                    </div>
                                </v-card>
                                <v-card class="mx-auto" :class="[`elevation-5`]" v-if="vista == 2">
                                    documentos
                                    <v-btn @click="vista = 0">b</v-btn>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="../modulos/gestion.js"></script>
</body>
</html>