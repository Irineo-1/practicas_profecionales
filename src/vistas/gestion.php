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

                    <v-btn
                        color="white"
                        @click="vistaAddInstitucion = 'addInstitucion', showAlertAddIns = false"
                        v-if="vistaAddInstitucion == 'alumnos'"
                    >
                        Agregar instituciones
                    </v-btn>
                    
                    <v-btn
                        color="white"
                        @click="vistaAddInstitucion = 'alumnos'"
                        v-if="vistaAddInstitucion == 'addInstitucion'"
                    >
                        Alumnos
                    </v-btn>

                    <v-btn
                        color="white"
                        @click="goToFiles"
                        icon="mdi-file-cloud"
                    >
                    </v-btn>

                    <v-btn
                        color="white"
                        @click="uploadAlumnos = true"
                        icon="mdi-account-multiple-plus"
                    >
                    </v-btn>

                    <v-btn
                        color="white"
                        @click="CerrarSesion"
                        icon="mdi-logout-variant"
                    >
                    </v-btn>

                    <v-spacer></v-spacer>

                    <div class="text-center">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                v-bind="props"
                            >
                            {{ nombreMaestro }} - {{ puesto }} - {{ turno }}
                            </v-btn>
                        </template>
                    </v-menu>
                    </div>
                </v-app-bar>

                <v-main>
                    <v-container fluid>
                        <v-row dense>
                            <v-col v-if="vistaAddInstitucion == 'alumnos'">
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
                                                <v-col cols="12" xs="1" sm="3" class="d-flex justify-end">
                                                    <v-switch label="Sin servicio" color="#6a1c37" inset v-model="sinServicio"></v-switch>
                                                </v-col>
                                                <v-col cols="12" xs="1" sm="3" class="d-flex justify-end">
                                                    <v-btn prepend-icon="mdi-file-cloud" @click="generarReporteMDL = true">
                                                        Reporte
                                                    </v-btn>
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
                                            :title="alumno.nombre_completo + ' - ' + alumno.turno"
                                            class="style-item-list"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    style="margin-right: 5px;"
                                                    icon="mdi-file-document-multiple-outline"
                                                    variant="tonal"
                                                    @click="seeDocuments(alumno.numero_control, alumno.nombre_completo)"
                                                >
                                                </v-btn>
                                                <v-btn
                                                    style="margin-right: 5px;"
                                                    icon="mdi-circle-edit-outline"
                                                    variant="tonal"
                                                    @click="getAlumnoSelected(alumno.id, alumno.nombre_completo)"
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
                                                    @click="downloadDocument(documento.nombre_documento, documento.proceso)"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCsolicitud"
                                            :key="documento.id"
                                            :title="'Solicitud de practicas profesionales'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-select
                                                label="Estatus"
                                                v-model="statusSolicitud"
                                                variant="underlined"
                                                style="margin-right: 15px;"
                                                :items="estados"
                                                item-title="estado"
                                                :item-props="documento.estatus"
                                                item-value="value"
                                                >
                                                </v-select>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                    @click="downloadDocument(documento.nombre_documento, documento.proceso)"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCcarta_aceptacion"
                                            :key="documento.id"
                                            :title="'Carta de aceptación'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-select
                                                label="Estatus"
                                                v-model="statusCartaAceptacion"
                                                variant="underlined"
                                                style="margin-right: 15px;"
                                                :items="estados"
                                                item-title="estado"
                                                :item-props="documento.estatus"
                                                item-value="value"
                                                >
                                                </v-select>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                    @click="downloadDocument(documento.nombre_documento, documento.proceso)"
                                                ></v-btn>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="documento in DOCcarta_liberacion"
                                            :key="documento.id"
                                            :title="'Carta de liberación'"
                                            :subtitle="documento.nombre_documento"
                                        >
                                            <template v-slot:append>
                                                <v-btn
                                                    icon="mdi-download-circle-outline"
                                                    variant="tonal"
                                                    @click="downloadDocument(documento.nombre_documento, documento.proceso)"
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
                                                                @click="downloadDocument(documento.nombre_documento, documento.proceso)"
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
                                    <v-card max-width="400" class="mx-auto" :class="[`elevation-0`]">
                                    <br>
                                    <v-alert
                                        v-if="showAlerta"
                                        closable
                                        :title="textoAlerta"
                                        :type="tipoAlerta"
                                    ></v-alert>
                                        <v-container>
                                            <v-row>
                                                <v-col>
                                                    <v-text-field
                                                        label="Nombre"
                                                        prepend-icon="mdi-account"
                                                        variant="solo"
                                                        v-model="nombreAlumnoSeleccionado"
                                                    ></v-text-field>
                                                    <v-text-field
                                                        label="Nueva contraseña"
                                                        prepend-icon="mdi-lock-outline"
                                                        variant="solo"
                                                        v-model="nuevaPassword"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                variant="elevated"
                                                color="green-lighten-1"
                                                @click="infoAccion = true"
                                            >
                                                Actualizar
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    <v-dialog
                                        width="500"
                                        v-model="infoAccion"
                                    >
                                        <v-card>
                                            <v-card-title>
                                                <v-icon color="blue">mdi-alert-circle-outline</v-icon>
                                                ¿Esta seguro de esta accion?
                                            </v-card-title>

                                            <v-card-text>
                                                Se actualizaran los datos modificados del usuario
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    text="Actualizar"
                                                    variant="elevated"
                                                    color="green-lighten-1"
                                                    @click="actualizarAlumno"
                                                ></v-btn>
                                                <v-btn
                                                    text="Cancelar"
                                                    variant="elevated"
                                                    color="red"
                                                    @click="infoAccion = false"
                                                ></v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <div class="d-flex justify-center" style="margin-top: 10px; margin-bottom: 10px;">
                                        <v-btn icon="mdi-arrow-left" @click="vista = 0"></v-btn>
                                    </div>
                                </v-card>
                            </v-col>
                            <v-col v-else>
                                <v-card class="mx-auto" :class="[`elevation-5`]">
                                    <v-card-text>
                                        <v-alert v-show="showAlertAddIns" title="Institucion agregada con exito" closable type="success"></v-alert>
                                        <v-text-field label="Nombre de la institución" variant="underlined" v-model="adNombreInstitucion"></v-text-field>
                                        <v-text-field label="Nombre del titular" variant="underlined" v-model="adNombreTitular"></v-text-field>
                                        <v-text-field label="Puesto del titular" variant="underlined" v-model="adPuestoTitular"></v-text-field>
                                        <v-text-field label="RFC" variant="underlined" v-model="adRfc"></v-text-field>
                                        <v-text-field label="Dirección" variant="underlined" v-model="adDireccion"></v-text-field>
                                        <v-text-field label="Telefono" type="number" variant="underlined" v-model="adTelefono"></v-text-field>
                                        <v-text-field label="Correo" :rules="emailRules" variant="underlined" v-model="adCorreo"></v-text-field>
                                        <v-text-field label="Nombre del testigo" variant="underlined" v-model="adNombreTestigo"></v-text-field>
                                        <v-text-field label="Puesto del testigo" variant="underlined" v-model="adPuestoTestigo"></v-text-field>
                                        <v-text-field label="Entidad federativa" variant="underlined" v-model="adEntidadFederativa"></v-text-field>
                                        <v-text-field label="Clave" variant="underlined" v-model="adClaveCentro"></v-text-field>
                                        <v-text-field label="Tipo de institucion" variant="underlined" v-model="adTipoInstitucion"></v-text-field>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="#6a1c37"
                                            variant="flat"
                                            @click="guardarInstitucion"
                                        >
                                            Agregar
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                        <v-dialog
                        v-model="generarReporteMDL"
                        width="500px"
                        >
                            <v-card>
                                <v-card-title class="text-h5">
                                    Generar reporte
                                </v-card-title>

                                <v-card-text>
                                    <v-select
                                    label="Selecciona un turno"
                                    v-model="turnoSelecReport"
                                    :items="turnos"
                                    variant="underlined"
                                    ></v-select>
                                    <v-select
                                    label="Selecciona una condicion"
                                    v-model="condicionReporte"
                                    :items="['Aun no han realizado el servicio social', 'Aun no se ha seleccionado una institucion', 'Ya realiza las practicas', 'Se culmino con las practicas']"
                                    variant="underlined"
                                    ></v-select>
                                </v-card-text>
                                
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn variant="text" @click="generarReporteMDL = false">
                                        Cancelar
                                    </v-btn>
                                    <v-btn
                                        color="green-darken-1"
                                        variant="text"
                                        @click="generarReporteAlumnos"
                                        v-if="condicionReporte.trim() != '' || turnoSelecReport.trim() != ''"
                                    >
                                        Generar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <v-dialog
                        v-model="uploadAlumnos"
                        width="500px"
                        >
                            <v-card>
                                <v-card-title class="text-h5">
                                    Agregar alumnos
                                </v-card-title>

                                <v-card-text>

                                    <v-select
                                    label="Selecciona un turno"
                                    v-model="turnoSelecReport"
                                    :items="turnos"
                                    variant="underlined"
                                    ></v-select>

                                    <v-select
                                    label="Selecciona una especialidad"
                                    v-model="especialidadSeleccionada"
                                    :items="especialidades"
                                    variant="underlined"
                                    ></v-select>

                                    <v-file-input
                                        show-size
                                        counter
                                        density="compact"
                                        accept=".xlsx"
                                        v-model="alumnosExcel"
                                        label="Click aqui para subir el documento con extencion .xlsx"
                                    ></v-file-input>
                                </v-card-text>
                                
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn variant="text" @click="uploadAlumnos = false">
                                        Cancelar
                                    </v-btn>
                                    <v-btn
                                        color="green-darken-1"
                                        variant="text"
                                        @click="guardarAlumnos"
                                        v-if="condicionReporte.trim() != '' || especialidadSeleccionada.trim() != ''"
                                    >
                                        Generar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-container>
                    <v-snackbar
                    color="#6a1c37"
                    rounded="pill"
                    v-model="smsError"
                    >
                    {{texto_error}}

                    <template v-slot:actions>
                        <v-btn
                        color="white"
                        variant="text"
                        @click="smsError = false"
                        
                        >
                        cerrar
                        </v-btn>
                    </template>
                    </v-snackbar>
                </v-main>
            </v-layout>
        </v-card>
    </div>

    <script type="module" src="../modulos/gestion.js"></script>
</body>
</html>