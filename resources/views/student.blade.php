<x-student_layout>
    <x-slot:title>
        Matrículas 2025-B
    </x-slot:title>
    <div class="main-content">

        <header class="topbar">
            <div class="titulo">Panel Principal</div>
            <div class="acciones">
                <button title="Mensajes">📧</button>
                <button title="Notificaciones">🔔</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" title="Cerrar sesión" style="background:none; border:none; cursor:pointer; font-size:16px;">
                        ⏻ Logout
                    </button>
                </form>
            </div>
        </header>


        <section id="contenido">
            <div class="bienvenida">
                <h1>Bienvenido al Sistema Académico</h1>
                <p>Seleccione un módulo del menú lateral para comenzar.</p>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>📅 Próximas clases</h3>
                    <p>Consulta los horarios de tus próximos cursos.</p>
                </div>
                <div class="card">
                    <h3>📊 Desempeño general</h3>
                    <p>Visualiza estadísticas de notas y asistencia.</p>
                </div>
                <div class="card">
                    <h3>🧾 Reportes</h3>
                    <p>Descarga informes de notas y asistencia.</p>
                </div>
            </div>
        </section>
    </div>

</x-student_layout>
