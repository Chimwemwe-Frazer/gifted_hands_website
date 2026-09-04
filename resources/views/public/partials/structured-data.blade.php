<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MedicalClinic",
    "@id": "{{ url('/') }}#clinic",
    "name": "Gifted Hands Private Clinic",
    "alternateName": "Gifted Hands Pvt Clinic",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}",
    "image": "{{ asset('imgs/Medical team home page.jpeg') }}",
    "description": "Gifted Hands Private Clinic provides patient-centered private healthcare in Lilongwe, Malawi, including general consultation, women's health, Under-5 care, physiotherapy, laboratory services, scanning, appointments, and ambulance services.",
    "telephone": "+265995767137",
    "email": "giftedhandspvtclinic@gmail.com",

    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Barron Avenue",
        "addressLocality": "Lilongwe",
        "addressCountry": "MW"
    },

    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
                "Sunday"
            ],
            "opens": "00:00",
            "closes": "23:59"
        }
    ],

    "availableService": [
        {
            "@type": "MedicalProcedure",
            "name": "General Consultation"
        },
        {
            "@type": "MedicalProcedure",
            "name": "Obstetrics and Gynaecology"
        },
        {
            "@type": "MedicalProcedure",
            "name": "Under-5 Clinic"
        },
        {
            "@type": "MedicalTherapy",
            "name": "Physiotherapy"
        },
        {
            "@type": "MedicalTest",
            "name": "Laboratory Services"
        },
        {
            "@type": "MedicalTest",
            "name": "Scanning"
        }
    ],

    "sameAs": []
}
</script>