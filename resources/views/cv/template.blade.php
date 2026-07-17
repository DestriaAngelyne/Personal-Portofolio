<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV {{ $profile->name ?? '' }}</title>
    <style>
        @page {
            margin: 0;
            size: 793px 1123px;
        }
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #2b2b2b;
            line-height: 1.5;
            position: relative;
            width: 793px;
            height: 1123px;
        }

        .sidebar {
            position: absolute;
            top: 0;
            left: 0;
            width: 226px;
            height: 1123px;
            background-color: #0d2a4d;
            color: #ffffff;
            padding: 50px 24px;
        }
        .main {
            position: absolute;
            top: 0;
            left: 270px;
            width: 483px;
            padding: 50px 4px;
        }

        /* ===== Sidebar ===== */
        .photo-wrap {
            text-align: center;
            margin-bottom: 34px;
        }
        .photo-wrap img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #ffffff;
        }
        .sidebar-section {
            margin-bottom: 30px;
        }
        .sidebar h2 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            padding-bottom: 7px;
            border-bottom: 1.5px solid rgba(255,255,255,0.35);
        }
        .sidebar p {
            margin-bottom: 9px;
            line-height: 1.6;
            font-size: 12px;
        }
        .edu-item {
            margin-bottom: 16px;
        }
        .edu-period {
            font-size: 10.5px;
            opacity: 0.8;
            margin-bottom: 3px;
        }
        .edu-school {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
        }
        .edu-major {
            font-size: 11.5px;
            opacity: 0.9;
        }
        .skill-category {
            font-size: 12px;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 7px;
            color: #ffffff;
            text-transform: capitalize;
        }
        .skill-category:first-child {
            margin-top: 0;
        }
        .skill-list {
            list-style: none;
        }
        .skill-list li {
            margin-bottom: 6px;
            font-size: 11.5px;
            line-height: 1.4;
        }

        /* ===== Main content ===== */
        .name {
            font-size: 28px;
            font-weight: bold;
            color: #0d2a4d;
            line-height: 1.2;
        }
        .major {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #555555;
            margin-top: 8px;
            margin-bottom: 36px;
        }
        .main-section {
            margin-bottom: 32px;
        }
        .main h2 {
            font-size: 16px;
            color: #0d2a4d;
            margin-bottom: 14px;
            padding-bottom: 7px;
            border-bottom: 2px solid #0d2a4d;
        }
        .main p.summary {
            line-height: 1.8;
            text-align: justify;
            font-size: 12.5px;
            color: #333333;
        }
        .project-item {
            margin-bottom: 22px;
        }
        .project-item:last-child {
            margin-bottom: 0;
        }
        .project-title {
            font-weight: bold;
            color: #0d2a4d;
            font-size: 14px;
            margin-bottom: 6px;
        }
        .project-desc {
            line-height: 1.7;
            font-size: 12.5px;
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        @if($photoBase64)
            <div class="photo-wrap">
                <img src="{{ $photoBase64 }}" alt="Foto Profil">
            </div>
        @endif

        <div class="sidebar-section">
            <h2>Kontak</h2>
            <p>{{ $profile->phone ?? '-' }}</p>
            <p>{{ $profile->email ?? '-' }}</p>
            <p>{{ $profile->location ?? '-' }}</p>
        </div>

        <div class="sidebar-section">
            <h2>Pendidikan</h2>
            @foreach($educations as $edu)
                <div class="edu-item">
                    <div class="edu-period">{{ $edu->period }}</div>
                    <div class="edu-school">{{ $edu->school }}</div>
                    @if($edu->major)
                        <div class="edu-major">{{ $edu->major }}</div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="sidebar-section">
            <h2>Skill</h2>
            @foreach($technologies as $category => $techs)
                <div class="skill-category">{{ $category }}</div>
                <ul class="skill-list">
                    @foreach($techs as $tech)
                        <li>&bull; {{ $tech->name }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>

    <div class="main">
        <div class="name">{{ strtoupper($profile->name ?? '') }}</div>
        <div class="major">{{ $profile->major ?? '' }}</div>

        <div class="main-section">
            <h2>Profil</h2>
            <p class="summary">{{ $profile->summary ?? '' }}</p>
        </div>

        <div class="main-section">
            <h2>Portofolio Proyek</h2>
            @foreach($projects as $project)
                <div class="project-item">
                    <div class="project-title">{{ $project->title }}</div>
                    <div class="project-desc">{{ $project->description }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
